@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Action to admitting a patient')

@section('content')

    <div class="box box-info">
        <div class="box-body">
            <h2>Patient Details</h2>
            <div class="col-lg-6">
                <strong>Name: </strong> {{ $admission->patient->full_name }}<br>
                <strong>Number:</strong> @if($patient->patient_no != null) {{ $admission->patient->patient_no }} @else
                    No Number Assigned @endif<br>
                <strong>Ward Name:</strong> {{ $admission->ward->name }}<br>
                <strong>Account Balance:</strong> Ksh. {{ $admission->patient->account->balance }} <br>
            </div>
            <div class="col-lg-6">
                <strong>Age: </strong> {{ $patient->age }} years<br>
                <strong>Admission Date:</strong> {{ date_format($admission->created_at,'l dS M, Y') }}<br>
                <strong>Bed Number:</strong> {{ $admission->bed->number }}<br>
                <strong>Deposit:</strong> Ksh. {{ $admission->patient->account->balance }}<br>
            </div>
        </div>

    </div>
    <hr>

    <div class="box box-info">
        <div class="box-body">

            <ul class="nav nav-tabs inpatient-tabs">
                <li role="presentation"class="active"><a data-toggle="tab" aria-controls="tab" href="#doctor">Doctor's Notes</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#prescription">Prescriptions</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#vitals">Patient Vitals</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#bp">Blood Pressure</a></li>
                <li><a data-toggle="tab" href="#temperature">Temperature</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#investigation">Investigations</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#procedures">Procedures</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#nurse">Nurse's Notes</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#discharge">Discharge</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#summary">Summary</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#history">History</a></li>
            </ul>

            <div class="tab-content">
                @include("Inpatient::admission.manage.doctor")
                @include("Inpatient::admission.manage.prescription")
                @include("Inpatient::admission.manage.vitals")
                @include('inpatient::admission.graphs.bp')
                @include('inpatient::admission.graphs.temperature')
                @include("Inpatient::admission.manage.investigations")
                @include("Inpatient::admission.manage.procedures")
               {{--  @include("Inpatient::admission.manage.nurse")
                @include("Inpatient::admission.manage.discharge")
                @include("Inpatient::admission.manage.summary")
                @include("Inpatient::admission.manage.history") --}}
            </div>

        </div>

    </div>
@endsection
