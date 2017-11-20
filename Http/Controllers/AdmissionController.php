<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Users\Repositories\UserRepository;
use Ignite\Inpatient\Repositories\BedRepository;
use Ignite\Inpatient\Repositories\WardRepository;
use Ignite\Inpatient\Http\Requests\AdmissionRequest;
use Ignite\Inpatient\Repositories\AdmissionRepository;
use Ignite\Inpatient\Repositories\AdmissionRequestRepository;

//Remove these later on 
use Carbon\Carbon;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\RecurrentCharge;
use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Finance\Entities\PatientAccount;
use Ignite\Inpatient\Entities\Administration;
use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\BedPosition;
use Ignite\Inpatient\Entities\BloodPressure;
use Ignite\Inpatient\Entities\BloodTransfusion;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\Discharge;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\FluidBalance;
use Ignite\Inpatient\Entities\InpatientConsumable;
use Ignite\Inpatient\Entities\Notes;
use Ignite\Inpatient\Entities\NursingCarePlan;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\Temperature;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\Vitals;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Helpers\InpatientHelpers;
use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\User;
use Ignite\Users\Entities\UserRoles;
use Validator;
//End of remove bits



class AdmissionController extends AdminBaseController
{
    protected $admissionRequestRepository, $userRepository;
    
    /*
    * Inject the various dependencies that will be required
    */
    public function __construct(AdmissionRequestRepository $admissionRequestRepository, WardRepository $wardRepository,
                                UserRepository $userRepository, AdmissionRepository $admissionRepository,
                                BedRepository $bedRepository)
    {
        parent::__construct();

        $this->admissionRequestRepository = $admissionRequestRepository;

        $this->userRepository = $userRepository;

        $this->wardRepository = $wardRepository;

        $this->bedRepository = $bedRepository;

        $this->admissionRepository = $admissionRepository;
    }

    /**
     * Display all the admissions
     */
    public function index()
    {
        $admissions = $this->admissionRepository->all();

        return view('inpatient::admissions.index', compact('admissions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create($id)
    {
        $admissionRequest = $this->admissionRequestRepository->find($id);

        $doctors = $this->userRepository->getUsersByRole('doctor');

        $wards = $this->wardRepository->all();

        $beds = $this->bedRepository->all();

        return view('inpatient::admission.create', compact('admissionRequest', 'doctors', 'wards', 'beds'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(AdmissionRequest $request)
    {
        $this->admissionRepository->create(request()->all());

        $this->admissionRequestRepository->delete(request()->get('inpatient_request_admission_id'));
        
        return redirect('/inpatient/admissions')->with(['success' => 'Patient has been admitted']);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($admissionId)
    {
        $admission = $this->admissionRepository->find($admissionId);

        $id = $admission->patient_id;

        $visit_id = $admission->visit_id;

    
            $patient = Patients::findorFail($id)->first();
    
            $ward_assigned = WardAssigned::where("visit_id", $visit_id)->first();
    
            $ward = $admission->ward;

            $admission = Admission::where('patient_id', $id)
                ->where("visit_id", $visit_id)->first();
            ///the vitals taken during visits
            /* all the visits for this patient */
            $vitals = null;
            $doctor_note = null;
    
            if (count(Visit::where('patient', $id)->get()) > 0) {
    //            $visit_id = Visit::where('patient', $id)
    //                ->orderBy('created_at', 'desc')->first()->id;
                $vitals = Vitals::where('visit_id', $visit_id)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                    return [
                        "id" => $item->id,
                        "height" => $item->height,
                        "weight" => $item->weight,
                        "bmi" => number_format($this->helper->calculateBMI($item->weight, $item->height), 2),
                        "bmi_status" => $this->helper->getBMIStatus($this->helper->calculateBMI($item->weight, $item->height)),
                        "bp" => $item->bp_systolic . "/" . $item->bp_diastolic,
                        "pulse" => $item->pulse,
                        "respiration" => $item->respiration,
                        "temperature" => $item->temperature,
                        "temperature_location" => $item->temperature_location,
                        "oxygen" => $item->oxygen,
                        "waist" => $item->waist,
                        "hip" => $item->hip,
                        "blood_sugar" => $item->blood_sugar,
                        "blood_sugar_units" => $item->blood_sugar_units,
                        "allergies" => $item->allergies,
                        "chronic_illnesses" => $item->chronic_illnesses,
                        "recorded_by" => $item->user->profile->fullName,
                        "date_time_recorded" => $item->date_recorded . " " . $item->time_recorded,
                        "timestamp" => $this->carbon->parse($item->created_at)->format('d/m/Y H:i A')
                    ];
                });
    
                $once_only_prescriptions = Prescriptions::where('visit', $visit_id)->where("type", 0)->where("for_discharge", 0)->orderBy("updated_at", "DESC")->get();
                $regular_prescriptions = Prescriptions::where('visit', $visit_id)->where("type", 1)->where("for_discharge", 0)->orderBy("updated_at", "DESC")->get();
    
                $discharge_prescriptions = Prescriptions::where('visit', $visit_id)->where("for_discharge", 1)->orderBy("updated_at", "DESC")->get();
    
                $doctorsNotes = Notes::where('visit_id', $visit_id)->where("type", 1)->get();
                $nursesNotes = Notes::where('visit_id', $visit_id)->where("type", 0)->get();
                $nursingCarePlans = NursingCarePlan::where('visit_id', $visit_id)->get();
                $transfusions = BloodTransfusion::where('visit_id', $visit_id)->get();
                $fluidbalances = FluidBalance::where("visit_id", $visit_id)->get()->map(function ($item) {
                    return
                        [
                            "id" => $item->id,
                            "intravenous_infusion_instructions" => $item->intravenous_infusion,
                            "intake_intravenous" => unserialize($item->intake_intravenous),
                            "intake_alimentary" => unserialize($item->intake_alimentary),
                            "output" => unserialize($item->output),
                            "recorded_by" => $item->user->profile->fullName,
                            "recorded_on" => $item->time_recorded . " " . $this->carbon->parse($item->date_recorded)->format('d/m/Y')
                        ];
                });
    
                $investigations = Investigations::where("visit", $visit_id)->where("type", "laboratory")->get()->map(function ($item) {
                    return
                        [
                            "id" => $item->id,
                            "type" => $item->type,
                            "procedure" => $item->procedures->name,
                            "quantity" => $item->quantity,
                            "price" => $item->price,
                            "discount" => $item->discount,
                            "amount" => $item->amount,
                            "user" => $item->doctors->profile->fullName,
                            "instructions" => $item->instructions,
                            "ordered" => $item->ordered,
                            "invoiced" => $item->invoiced,
                            "requested_on" => $this->carbon->parse($item->updated_at)->format('H:i A d/m/Y ')
                        ];
                });
    
                $charges = $this->buildChargeSheet($visit_id, 1);
    
            }
    
            $bpChart = $this->getCharts($patient->id, $admission->id);
            $tempChart = $this->getTemperatureChart($patient->id, $admission->id);
    
            return view('Inpatient::admissions.show', compact('tempChart', 'investigations', 'bpChart', 'patient', 'ward', 'admission', 'vitals', 'doctorsNotes', 'nursesNotes', 'once_only_prescriptions', 'regular_prescriptions', 'nursingCarePlans', 'transfusions', 'fluidbalances', 'discharge_prescriptions', 'charges'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('inpatient::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }




    /*
    * Remove this method entirely later
    */
    public function buildChargeSheet($visit_id, $type = null)
    {
        $wardCharges = 0;
        $recuCharges = 0;
        $totalNursingAndWardCharges = 0;
        $totalInvestigationsCharges = 0;
        $totalProceduresCharges = 0;
        $totalConsumablesCharges = 0;
        $totalDispensedDrugs = 0;
        $totalDischargeDrugs = 0;
        $totalBill = 0;

        $admission = Admission::where('visit_id', $visit_id)->first();
        // Check total days based on discharge and admission date
        $daysAdmitted = $admission->created_at->diffInDays(Carbon::now());
        $wards = WardAssigned::where('visit_id', $visit_id)->get();
        $rcnt = RecurrentCharge::where('visit_id', $visit_id)->get();

        $done_investigations = get_inpatient_investigations($visit_id);
        $consumption_list = InpatientConsumable::whereVisit($visit_id)->get();
        $done_procedures = get_inpatient_investigations($visit_id, 'procedure');
        $dispensed_drugs = Prescriptions::where("visit", $visit_id)->where("status", 1)->get();
        $discharge_drugs = Prescriptions::where("visit", $visit_id)->where("for_discharge", 1)->get();
        $admission = Admission::where("visit_id", $visit_id)->first();

        // Calculate Totals 
        foreach ($wards as $ward) {
            $days_if_discharged = ((($this->carbon->parse($ward->discharged_at)->diffInDays($ward->created_at)) > 0) ? ($this->carbon->parse($ward->discharged_at)->diffInDays($ward->created_at)) : 1);
            $days_not_discharged = (($this->carbon->now()->diffInDays($ward->created_at) > 0) ? $this->carbon->now()->diffInDays($ward->created_at) : 1);
            $wardCharges += $ward->price * (($ward->discharged_at != null) ? $this->carbon->parse($ward->discharged_at)->diffInDays($ward->created_at) : ($this->carbon->now()->diffInDays($ward->created_at) > 0) ? $this->carbon->now()->diffInDays($ward->created_at) : 1);
            //subscribed reccurrent charges
            foreach ($rcnt as $recurrent) {
                //nursing charges times no. of days..
                $recuCharges += ($ward->discharged_at != null) ? NursingCharge::find($recurrent->recurrent_charge_id)->cost * $days_if_discharged : NursingCharge::find($recurrent->recurrent_charge_id)->cost * $days_not_discharged;
            }
        }

        foreach ($dispensed_drugs as $d) {
            $totalDispensedDrugs += $admission->visit->payment_mode == 'cash' ? $d->drugs->prices[0]->cash_price * Administration::where("prescription_id", $d->id)->count() : $d->drugs->prices[0]->credit_price * Administration::where("prescription_id", $d->id)->count();
        }

        foreach ($discharge_drugs as $d) {
            $totalDischargeDrugs += $admission->visit->payment_mode == 'cash' ? $d->drugs->prices[0]->cash_price * Administration::where("prescription_id", $d->id)->count() : $d->drugs->prices[0]->credit_price * Administration::where("prescription_id", $d->id)->count();
        }

        $totalNursingAndWardCharges = $wardCharges + $recuCharges;
        $totalInvestigationsCharges = $done_investigations->sum('amount');
        $totalConsumablesCharges = $consumption_list->sum('amount');
        $totalProceduresCharges = $done_procedures->sum('amount');
        $totalPrescriptionCharges = $totalDispensedDrugs + $totalDischargeDrugs;

        $totalBill = $totalNursingAndWardCharges + $totalInvestigationsCharges + $totalConsumablesCharges + $totalProceduresCharges + $totalPrescriptionCharges;

        $charges = ['admission' => $admission, 'recurrent_charges' => $rcnt, 'wards' => $wards, 'investigations' => $done_investigations, 'consumables' => $consumption_list, 'procedures' => $done_procedures, 'dispensed_drugs' => $dispensed_drugs, 'discharge_drugs' => $discharge_drugs, 'totalNursingAndWardCharges' => $totalNursingAndWardCharges, 'daysAdmitted' => $daysAdmitted, 'totalPrescriptionCharges' => $totalPrescriptionCharges, 'totalBill' => $totalBill];

        if ($type == 1) {
            return $charges;
        }

        return view('Inpatient::admission.print.charge_sheet', compact('charges'));

        // $pdf =\PDF::loadView('Inpatient::admission.print.charge_sheet', ['charges' => $charges]);        
        // $pdf->setPaper('a4', 'portrait');
        // return $pdf->download('charge_sheet_'.str_random(10).'.pdf');
    }

    private function getCharts($patient, $admission)
    {
        $bp = BloodPressure::wherePatientId($patient)->whereAdmissionId($admission)->get();
        return \Charts::multi('line', 'highcharts')
            ->title('Blood Pressure Chart')
//            ->elementLabel('Blood Pressure')
            ->labels($bp->pluck('date'))
            ->dataset('Blood Pressure', $bp->pluck('value'))
            ->dataset('Diastolic', $bp->pluck('diastolic'))
//            ->values()
            ->template('material')
            ->container('bp_chart')
            ->width(0)
            ->height(0);

    }

    private function getTemperatureChart($patient, $admission)
    {
        $t = Temperature::wherePatientId($patient)->whereAdmissionId($admission)->get();
        return \Charts::create('line', 'highcharts')
            ->title('Temperature Chart')
            ->elementLabel('Temperature')
            ->labels($t->pluck('date'))
            ->values($t->pluck('temperature'))
            ->template('material')
            ->container('temp_chart')
            ->width(0)
            ->height(0);
        /* return \Charts::realtime(
             url('api/inpatient/v1/get/temperature'), 2000, 'line', 'highcharts')
             ->values($t->pluck('value'))
             ->labels($t->pluck('created_at'))
             ->responsive(false)->elementLabel('Temperature')
             ->height(300)
             ->width(0)
             ->title('Temperature')
             ->valueName('temperature');*/

    }
}
