@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Action to admitting a patient')

@section('content')
{{-- 
    <div class="box box-info">
        

    </div> --}}

    <div class="box box-info">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingZero">
                <h4 class="panel-title">
                    <div>
                        <ul class = "accordion-header single-btn">
                            <li class = "title"><b>{{ $admission->patient->full_name }}</b> ({{ $patient->age }} yrs old) at Bed {{ $admission->bed->number }}, {{ $admission->ward->name }} Ward</li>
                            <li class = "options">
                                <span class="input-group-btn">
                                    <a role="button"  data-toggle="collapse" data-parent="#accordion" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                    <button type="button" class="btn btn-default" id = "btnCollapse"><i class="fa fa-chevron-down"></i></button>
                                    </a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </h4>
            </div>
            <div id="collapseZero" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingZero">
                <div class="panel-body">
                    <div class="box-body">
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
            </div>
        </div>
    </div>
    <hr>

    <div class="box box-info">
        <div class="box-body">

            <ul class="nav nav-tabs inpatient-tabs">
                <li role="presentation" class="active"><a data-toggle="tab" aria-controls="tab" href="#doctor">Doctor's Notes</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#nurse">Nurse's Notes</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#prescription">Prescriptions</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#vitals">Patient Vitals</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#bp">Blood Pressure</a></li>
                <li role="presentation"><a data-toggle="tab" href="#temperature">Temperature</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#investigation">Investigations</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#procedures">Procedures</a></li>
                
               {{--  <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#discharge">Discharge</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#summary">Summary</a></li>
                <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#history">History</a></li> --}}
            </ul>

            <div class="tab-content">
                @include("Inpatient::admission.manage.doctor")
                @include("Inpatient::admission.manage.nurse")
                @include("Inpatient::admission.manage.prescription")
                @include("Inpatient::admission.manage.vitals")
                @include('inpatient::admission.graphs.bp')
                @include('inpatient::admission.graphs.temperature')
                @include("Inpatient::admission.manage.investigations")
                @include("Inpatient::admission.manage.procedures")
               {{--  @include("Inpatient::admission.manage.discharge")
                @include("Inpatient::admission.manage.summary")
                @include("Inpatient::admission.manage.history") --}}
            </div>

        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            var toggled = false;

            $("#btnCollapse").click(function(){
                if(!toggled){
                    $("#btnCollapse > i").attr('class', "fa fa-chevron-down");
                    toggled = true;
                }else{
                    $("#btnCollapse > i").attr('class', "fa fa-chevron-up");
                    toggled = false;
                }
            });
        });
    </script>
@endsection
