<?php

namespace Ignite\Inpatient\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Validator;

use Ignite\Reception\Entities\Patients;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Evaluation\Entities\RecurrentCharge;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\Discharge;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\Deposit;
//use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Finance\Entities\PatientAccount;
use Ignite\Evaluation\Entities\Vitals;
//use Ignite\Inpatient\Entities\PatientAccount;

class AccountsController extends Controller
{

    public function Nursing_services(Request $request) {
        $charges = NursingCharge::all();
        $wards = Ward::all();
        return view('Inpatient::admission.nursing_services', compact('charges', 'wards'));
    }

    public function AddReccurentCharge(Request $request) {
        $req = request()->all();
        if ($req['type'] != 'nursing') {
            $req['ward_id'] = null;
        }
        NursingCharge::create($req);
        return redirect()->back()->with('success', 'Successfully added a new recurrent charge');
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

        return view('Evaluation::inpatient.withdraw', compact('deposits', 'patients'));
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
