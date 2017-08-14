<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
//extract($data);
?>
@extends('layouts.app')
@section('content_title','Patient Accounts')
@section('content_description','Withdraw From Patient Account')

@section('content')

@include('Evaluation::inpatient.success')

<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Patient Account</h3>
    </div>
    <div class="box-body">
        <div class="col-lg-5">
            <dt>Name:</dt><dd>{{$patient->full_name}}</dd>
            <dt>Phone:</dt><dd>{{$patient->mobile}}</dd>
            <strong><dt>Account Balance:</dt><dd style="font-size: bold">Kshs.
            @if(\Ignite\Evaluation\Entities\PatientAccount::where('patient_id',$patient->id)->first())
            {{number_format(\Ignite\Evaluation\Entities\PatientAccount::where('patient_id',$patient->id)->first()->balance,2)}}
            @else
            {{number_format(0.00,2)}}
            @endif
            </dd></strong>
        </div>

    <div class="col-lg-7">
        <div class="form-horizontal">
        <a href="{{url('finance/evaluation/accounts')}}" class="btn btn-primary">Back</a>
        <a href="{{url($a)}}" target="_tab" class="btn btn-primary"> <i class="fa fa-print"></i> Print</a >
      </div>
    </div>

        <br><br>
        <hr>



<div class="row">
    
</div>


    <div class="box-footer">
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('table').DataTable();
        } catch (e) {
        }

    });
</script>
@endsection