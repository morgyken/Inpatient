<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>

@extends('layouts.app')
@section('content_title','Request Patient Discharge')
@section('content_description','request Patient Discharge')

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Confirm Patient Discharge</h3>
    </div>
    <div class="box-body">
       
       <?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>
@include('Inpatient::includes.success')

 <div class="col-md-6">
            <h4>Patient Information</h4>
            <dl class="dl-horizontal">
                <dt>Name:</dt><dd>{{ $admission->patient->fullname }}</dd>
                <dt>Date of Birth:</dt><dd>{{ (new Date($admission->patient->dob))->format('m/d/y') }}
                    <strong>({{ $admission->patient->age }} years old)</strong></dd>
                <dt>Gender:</dt><dd>{{ $admission->patient->sex }}</dd>
                <dt>Mobile Number:</dt><dd>{{ $admission->patient->mobile }}</dd>
            </dl>
        </div>
        <div class="col-md-6">
            <dl class="dl-horizontal">
                <dt>Patient Account Balance:</dt><dd>Kshs. {{ number_format($admission->patient->account->balance,2) }}</dd>
                <dt>Pending Balance: </dt> <dd> Kshs. {{ number_format($admission->patient->account->balance,2) }}</dd>
            </dl>
        </div>
        <br><br>

<div class="row">

     @if($admission->Discharged == false)
        @if($admission->has_discharge_request == true)
            <form role="form">  
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label style="padding: 0 !important;">Reason for discharge</label>
                        <textarea name="discharge_reason" id="discharge_reason" class="form-control" rows="3" cols="10" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-offset-4 col-md-9 col-lg-8">
                    <br/><br/>
                    <div class="pull-right">
                        <button type="button" class="btn btn-lg btn-primary" id = "request-discharge"><i class="fa fa-save"></i> Request Discharge</button>
                    </div>
                </div>
            </form>
        @else
            <div class="alert alert-info">
                <strong><i class="fa fa-exclamation-circle"></strong> This patient already has a discharge request
            </div>
        @endif
    @else
        <div class="alert alert-info">
            <strong><i class="fa fa-exclamation-circle"></strong> This patient has already been discharged
        </div>
    @endif

</div>
        
<script type="text/javascript">
    $(function () {
        var VISIT_ID = "{{ $admission->visit_id }}";
        var ADMISSION_ID = "{{ $admission->id }}";
        var USER_ID = "{{ Auth::user()->id }}";
        var REQUEST_DISCHARGE_POST_URL = "{{ url('/api/inpatient/v1/discharge/request') }}";
        
        $('#request-discharge').click(function(e){
                var reason = $.trim($("#discharge_reason").val());
                if(reason.length > 0){
                    $.ajax({
                        type: "POST",
                        url: REQUEST_DISCHARGE_POST_URL,
                        data: JSON.stringify({  
                            visit_id : VISIT_ID,
                            admission_id: ADMISSION_ID,
                            doctor_id: USER_ID,
                            reason: reason
                        }),
                        success: function (resp) {
                             if(resp.type === "success"){
                                alertify.success(resp.message);
                                window.location = "{{ url('/inpatient/request_discharge') }}";
                            }else{
                                alertify.error(resp.message);
                            }
                        },
                        error: function (resp) {
                            alertify.error(resp.message);
                        }
                    });
                }else{
                    alertify.error("You must first provide a reason for discharge!");
                }
            });         

    });
</script>
@endsection