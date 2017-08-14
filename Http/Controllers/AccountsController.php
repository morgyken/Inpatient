<?php

namespace Ignite\Inpatient\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Validator;

use Ignite\Reception\Entities\Patients;
use Ignite\Evaluation\Entities\NursingCharge;
use Ignite\Evaluation\Entities\RecurrentCharge;
use Ignite\Evaluation\Entities\RequestDischarge;
use Ignite\Evaluation\Entities\Discharge;
use Ignite\Evaluation\Entities\WardAssigned;
use Ignite\Evaluation\Entities\DischargeNote;
use Ignite\Evaluation\Entities\Deposit;
use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Evaluation\Entities\Patient_vital;
use Ignite\Evaluation\Entities\PatientAccount;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('inpatient::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('inpatient::create');
    }

    public function Nursing_services(Request $request) {
        $charges = NursingCharge::all();
        $wards = Ward::all();
        return view('Evaluation::inpatient.Nursing_services', compact('charges', 'wards'));
    }

    public function AddReccurentCharge(Request $request) {
        $req = (request()->all());
        if ($req['type'] != 'nursing') {
            $req['ward_id'] = null;
        }
        NursingCharge::create($req);
        return redirect()->back()->with('success', 'Successfully added a new recurrent charge');
    }

     public function topUpAmount(Request $request) {
        if (count(PatientAccount::where('patient_id', $request->patient_id)->get())) {
            $patient = PatientAccount::where('patient_id', $request->patient_id)->first();
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
        $patient = (Patients::find($patient->patient_id));
        $request['depo'] = $depo;
        $request['balance'] = $balance;
        $request['patient'] = $patient;
        $amount = $request['amount'];


        $tras = $depo;


//        return view('Evaluation::inpatient.print.topUpSlip',compact('tras','patient','balance','amount'));
        $pdf = \PDF::loadView('Evaluation::inpatient.print.topUpSlip', ['tras' => $tras, 'patient' => $patient, 'balance' => $balance, 'amount' => $amount]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Deposit_slip' . str_random(4) . '.pdf');


        return view('Evaluation::inpatient.deposit_slip', compact('patient', 'depo', 'balance'));
    }

    public function withdraw() {
        $patients = Patients::all();
        $deposits = FinancePatientAccounts::where('debit', '>', 0)->get();

        return view('Evaluation::inpatient.withdraw', compact('deposits', 'patients'));
    }

    public function WithdrawAmount(Request $request) {
        //search for the account..
        if (count(PatientAccount::where('patient_id', $request->patient_id)->get())) {
            $patient_acc = PatientAccount::where('patient_id', $request->patient_id)->first();
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

        $pdf = \PDF::loadView('Evaluation::inpatient.print.withdraw', ['tras' => $wit, 'patient' => $patient, 'balance' => $balance, 'amount' => $request->amount]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Deposit_slip' . str_random(4) . '.pdf');


        $pdf = \PDF::loadView('Evaluation::inpatient.print.withdraw', ['tras' => $wit, 'patient' => $patient, 'balance' => $balance, 'amount' => $request->amount]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Withdraw_slip' . str_random(4) . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('inpatient::show');
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
}
