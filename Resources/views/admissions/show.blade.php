<?php
$visit = \Ignite\Inpatient\Entities\Visit::findOrNew($admission->visit_id);
?>
@extends('layouts.app')
@section('content_title','Admission Management')
@section('content_description','Manage a patient whose been admitted')

@section('content')
<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-user"></i> {{ $patient->full_name }} | 
        {{ $patient->dob->age }} yr old, {{ $patient->sex }}

        <b class="pull-right">
            <i class="fa fa-h-square"></i> {{ $admission->ward->name }} | 
            <i class="fa fa-bed"></i> {{ $admission->bed->number }}
        </b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6">
                <strong>Number:</strong> @if($patient->patient_no != null) {{ $admission->patient->patient_no }} @else
                    No Number Assigned @endif<br>
                <strong>Account Balance:</strong> Ksh. {{ $admission->patient->account->balance }} <br>
            </div>
            <div class="col-lg-6">
                <strong>Admission Date:</strong> {{ date_format($admission->created_at,'l dS M, Y') }}<br>
                <strong>Deposit:</strong> Ksh. {{ $admission->patient->account->balance }}<br>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="box box-info">
    <div class="box-body">

        <ul class="nav nav-tabs inpatient-tabs">
            <li role="presentation" class="active"><a data-toggle="tab" aria-controls="doctor" href="#doctor">Doctor's
                    Notes</a></li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#nurse">Nurse's Notes</a></li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#prescription">Prescriptions</a>
            </li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#vitals">Patient Vitals</a></li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#bp">Blood Pressure</a></li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#temp">Temperature</a></li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab"
                                        href="#investigationTab">Investigations</a></li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#procedureTab">Procedures</a>
            </li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#blood">Blood Trans.</a></li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#fluidbalance">Fluid Balance</a>
            </li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#plan">Care Plan</a></li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#consumableTab">Consumables</a>
            </li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#discharge">Discharge</a></li>
            <li role="presentation"><a data-toggle="tab" aria-controls="tab" href="#chargesheet">Charge Sheet</a>
            </li>
        </ul>

        <div class="tab-content">
            @include("Inpatient::admission.manage.doctor")
            @include("Inpatient::admission.manage.nurse")
            @include("Inpatient::admission.manage.prescription")
            <!-- @include("Evaluation::partials.doctor.prescription") -->
            @include("Inpatient::admission.manage.vitals")
            @include('inpatient::admission.graphs.bp')
            @include('inpatient::admission.graphs.temperature')
            @include("Inpatient::admission.manage.investigations")
            @include("Inpatient::admission.manage.procedure")
            @include('inpatient::admission.manage.transfusion')
            @include('inpatient::admission.manage.fluidbalance')
            @include('inpatient::admission.manage.care_plan')
            @include("Inpatient::admission.manage.consumable")
            @include("Inpatient::admission.manage.discharge")
            @include("Inpatient::admission.manage.chargesheet")
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var toggled = false;

        $("#btnCollapse").click(function () {
            if (!toggled) {
                $("#btnCollapse > i").attr('class', "fa fa-chevron-down");
                toggled = true;
            } else {
                $("#btnCollapse > i").attr('class', "fa fa-chevron-up");
                toggled = false;
            }
        });
    });
</script>
@endsection
