<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Patient Accounts')
@section('content_description','Deposit To Patient Account')

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
        {!! Form::open(['url'=>'/evaluation/inpatient/topUpAccount']) !!}
        <div class="col-md-12">
    <h3>Deposit</h2>
        <input type="hidden" name="patient_id" value="{{$patient->id}}">
            <div class="col-md-12">
                <div class="form-group {{ $errors->has('cash') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Cash Amount:</label>
                    <div class="col-md-8">
                         <input type="number"  required name="cash" class="amount form-control" />
                    </div>
                </div>
                <div class="form-group {{ $errors->has('cheque') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Cheque Amount:</label>
                    <div class="col-md-8">
                         <input type="number"  required name="cheque" class="amount form-control" />
                    </div>
                </div>
                <div class="form-group {{ $errors->has('chequenumber') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Cheque Number:</label>
                    <div class="col-md-8">
                         <input type="text"  required name="chequenumber" class="form-control" />
                    </div>
                </div>
                 <div class="form-group {{ $errors->has('cheque') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Mpesa Amount:</label>
                    <div class="col-md-8">
                         <input type="number"  required name="mpesa" class="amount form-control" />
                    </div>
                </div>
                <div class="form-group {{ $errors->has('cheque') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Mpesa Transaction Code:</label>
                    <div class="col-md-8">
                         <input type="text"  required name="mpesaTransactionCode" class="mpesatrans form-control" />
                    </div>
                </div>


                <div class="pull-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-money"></i> Deposit</button>
                </div>
            </div>
        </div> 
        {!! Form::close() !!}
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
$(".amount").change(function () {
    if(this.value < 0){
        this.value = 0;
    }
});

    });
</script>
@endsection