@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Action to admitting a patient')

@section('content')

    <div class="box box-info">
        <div class="box-body">
            <h2>Patient Details</h2>
            <div class="col-lg-6">
                <strong>Name: </strong> {{ $patient->full_name }}<br>
                <strong>Number:</strong> @if($patient->patient_no != null) {{ $patient->patient_no }} @else No Number Assigned @endif<br>
                <strong>Ward Name:</strong>  {{ $ward->name }}<br>
                <strong>Account Balance:</strong> Ksh. {{ $patient->account->balance }} <br>
            </div>
            <div class="col-lg-6">

                <strong>Age: </strong> {{ $patient->age }}<br>
                <strong>Admission Date:</strong> {{ date_format($admission->created_at,'l dS M, Y') }}<br>
                <strong>Bed Number:</strong> {{ $patient->admission->bed->number }}<br>
                <strong>Deposit:</strong> Ksh. {{ $patient->account->balance }}<br>
            </div>
        </div>

    </div>
    <hr>


    <div class="box box-info">
        <div class="box-body">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#vitals">Patient Vitals</a></li>
                <li><a data-toggle="tab" href="#doctor">Doctor's Notes</a></li>
                <li><a data-toggle="tab" href="#nurse">Nurse's Notes</a></li>
                <li><a data-toggle="tab" href="#investigations">Investigations</a></li>
                <li><a data-toggle="tab" href="#treatment">Treatment</a></li>
                <li><a data-toggle="tab" href="#prescription">Prescription</a></li>
                <li><a data-toggle="tab" href="#discharge">Discharge</a></li>
                <li><a data-toggle="tab" href="#summary">Summary</a></li>
                <li><a data-toggle="tab" href="#history">History</a></li>
            </ul>

            <div class="tab-content">
                
                @include("Inpatient::admission.manage.vitals")
                @include("Inpatient::admission.manage.doctor")
                @include("Inpatient::admission.manage.nurse")
                @include("Inpatient::admission.manage.investigations")
                @include("Inpatient::admission.manage.treatment")
                @include("Inpatient::admission.manage.prescription")
                @include("Inpatient::admission.manage.discharge")
                @include("Inpatient::admission.manage.summary")
                @include("Inpatient::admission.manage.history")
             
              {{--   <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Some content in menu 2.</p>
                </div> --}}
            </div>
        </div>

    </div>
@endsection