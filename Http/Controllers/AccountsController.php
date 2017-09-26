<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Validator;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Reception\Entities\Patients;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\RecurrentCharge;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\Discharge;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Finance\Entities\PatientAccount;
use Ignite\Inpatient\Entities\Vitals;
use Ignite\Inpatient\Entities\Ward;

class AccountsController extends AdminBaseController
{
    public function __construct(){
         parent::__construct();
    }

    public function getNursingServices(Request $request) {
        $charges = NursingCharge::all();
        $wards = Ward::all();
        return view('Inpatient::admission.nursing_services', compact('charges', 'wards'));
    }

    
    public function delete_service($id)
    {
        $service = NursingCharge::find($id);
        if ($service) {
            $service->delete();
        }
        return redirect()->back()->with('success', 'Successfully deleted a recurrent charge.');
    }

    public function addReccurentCharge(Request $request) {
        \DB::beginTransaction();
        try{
            $req = request()->all();
            if ($req['type'] == 'admission') {
                $req['ward_id'] = null;
            }else{
                foreach ($req['ward_id'] as $w) {
                    $n = new NursingCharge;
                    $n->name = $request->name;
                    $n->cost = $request->cost;
                    $n->ward_id = $w;
                    $n->type = $request->type;
                    $n->save();
                }
            }
            \DB::commit();
            return redirect()->back()->with('success', 'Successfully added a new recurrent charge');
        }catch(\Exception $e){
            \DB::rollback();
            return redirect()->back()->with('error', 'An error occured.Could not add new recurrent charges');
        }
    }

     public function deposit() {
        
        return view('Inpatient::account.deposit');
    }

    public function getAllDeposits(){
        $deposits = Deposit::get()->map(function($d){
            return [
                'id'            => $d->id,
                'name'          => $d->name,
                'cost'          => 'Ksh. '. $d->cost,
                'created_at'    => $d->created_at->format('d/m/Y H:i a')
            ];
        })->toArray();

        $data = [];
        foreach($deposits as $key => $d){
            $data[] = [
                $d['name'], 
                $d['cost'],
                $d['created_at'],
                '<button class="btn btn-primary btn-xs delete" value="'.$d["id"].'">Edit</button>
                <a class="btn btn-danger btn-xs" href="'.url("/inpatient/accounts/delete_deposit/".$d["id"]."").'><i class="fa fa-trash"></i> Delete</a>'
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function edit_deposit($id) {
        return Deposit::find($id);
    }

    public function addDepositType(Request $request) {
        Deposit::create($request->all());
        return redirect()->back()->with('success', 'successfully added a new deposit type');
    }


    public function editDeposit(Request $request) {
        \DB::beginTransaction();
        try{
            $dep = Deposit::find($request->deposit_id)->first();
            if($dep){
                $request['name'] = $request->deposit;
                $dep->update($request->all());
                \DB::commit();
                return redirect()->back()->with('success', 'updated deposit type successfully');
            }else{
                redirect()->back()->with('error', 'Deposit Type does not exist');
            }
           
        }catch(\Exception $e){
            \DB::rollback();
            redirect()->back()->with('error', 'An error occured. Could not add a new deposit type');
        }
    }

    public function delete_deposit($deposit_id) {
        $d = Deposit::find($deposit_id)->first();
        $d->delete();
        if (Admission::where('cost', $d->cost)->count()) {
            return redirect()->back()->with('error', 'Could not delete the deposit.');
        }
        return redirect()->back()->with('success', 'Successfully deleted');
    }

    public function topUpAmount(Request $request) {
        if (count(PatientAccount::where('patient', $request->patient_id)->get())) {
            $patient = PatientAccount::where('patient', $request->patient_id)->first();
            $patient->update(['balance' => $patient->balance + $request->amount]);
        } else {
            $request['balance'] = $request->amount;
            $patient = PatientAccount::create($request->all());
        }

        $request['patient'] = $request->patient_id;
        $request['reference'] = 'deposit_' . str_random(5);
        $request['details'] = 'deposit to patient\' account';
        $request['debit'] = 0.00;
        $request['credit'] = $request['amount'];

        $depo = FinancePatientAccounts::create($request->all());
        $balance = $patient->balance;
        $patient = Patients::findOrFail($patient->patient_id)->first();
        $request['depo'] = $depo;
        $request['balance'] = $balance;
        $request['patient'] = $patient;
        $amount = $request['amount'];

        $tras = $depo;

        $pdf = \PDF::loadView('Inpatient::admission.print.topUpSlip', ['tras' => $tras, 'patient' => $patient, 'balance' => $balance, 'amount' => $amount]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Deposit_slip' . str_random(4) . '.pdf');

        return view('Inpatient::admission.deposit_slip', compact('patient', 'depo', 'balance'));
    }

    public function withdraw() {
        $patients = Patients::all();
        $deposits = FinancePatientAccounts::where('debit', '>', 0)->get();

        return view('Inpatient::inpatient.withdraw', compact('deposits', 'patients'));
    }

    public function WithdrawAmount(Request $request) {
        //search for the account..
        if (count(PatientAccount::where('patient', $request->patient_id)->get())) {
            $patient_acc = PatientAccount::where('patient', $request->patient_id)->first();
            $account_balance = $patient_acc->balance;
        } else {
            $account_balance = 0;
        }

        if ($request->amount > $account_balance) {
            $validator = Validator::make($request->all(), ['amount' => 'required']);
            $validator->errors()
                    ->add('amount', 'Insufficient fund in your account to withdraw Kshs. ' . $request->amount);
            return redirect()->back()->withErrors($validator);
        }

        //reduce the amount
        $patient_acc->update(['balance' => $account_balance - $request->amount]);

        $wit = FinancePatientAccounts::create([
            'reference' => 'withdraw_' . str_random(5),
            'details' => 'withdraw amount from patient account',
            'debit' => $request->amount,
            'credit' => 0.00,
            'patient' => $request->patient_id
        ]);
        $patient = Patients::find($request->patient_id);
        $balance = $patient_acc->balance;

        $pdf = \PDF::loadView('Inpatient::admission.print.withdraw', ['tras' => $wit, 'patient' => $patient, 'balance' => $balance, 'amount' => $request->amount]);
        $pdf->setPaper('a4', 'Landscape');

        return $pdf->stream('Deposit_slip' . str_random(4) . '.pdf');

        $pdf = \PDF::loadView('Inpatient::admission.print.withdraw', ['tras' => $wit, 'patient' => $patient, 'balance' => $balance, 'amount' => $request->amount]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Withdraw_slip' . str_random(4) . '.pdf');
    }

   
}
