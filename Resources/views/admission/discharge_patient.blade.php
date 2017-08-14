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
@section('content_title','Discharge Patient')
@section('content_description','Confirm Discharge of Patient')

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
@include('Evaluation::inpatient.success')

 <div class="col-md-4">
            <h4>Patient Information</h4>
            <dl class="dl-horizontal">
                <dt>Name:</dt><dd>{{$patient->full_name}}</dd>
                <dt>Date of Birth:</dt><dd>{{(new Date($patient->dob))->format('m/d/y')}}
                    <strong>({{(new Date($patient->dob))->age}} years old)</strong></dd>
                <dt>Gender:</dt><dd>{{$patient->sex}}</dd>
                <dt>Mobile Number:</dt><dd>{{$patient->mobile}}</dd>
            </dl>
        </div>


<div class="row">

    <div class="form-horizontal">
        {!! Form::open(['url'=>'/evaluation/inpatient/postDischargePatient']) !!}
        <div class="col-md-12">
                <input type="hidden" name="visit_id" value="{{$v->id}}">
            <div class="col-md-6">
                 <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Discharge Type</label>
                    <div class="col-md-8">
                    <select name="type" id="discharge_type" class="form-control">
                            <option value="discharge">Discharge Summary</option>
                            <option value="case">Case Discharge</option>
                        </select>
                    </div>
                </div>
                
                <div class="case form-group {{ $errors->has('dateofdeath') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Date Of Death</label>
                    <div class="col-md-8">
                         <input type="text" name="dateofdeath" class="form-control date" />
                    </div>
                </div>
            

                <div class="case form-group {{ $errors->has('timeofdeath') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Time Of Death</label>
                    <div class="col-md-8">
                         <input type="text" name="timeofdeath" class="form-control time" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
               
                <div class="form-group {{ $errors->has('DischargeNote') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Discharge Note </label>
                    <div class="col-md-8">
                    <textarea required name="DischargeNote" class="form-control">
                    </textarea>
                    </div>
                </div>
            
                <div class="pull-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div> 
        {!! Form::close() !!}
    </div>
</div>
        
<script type="text/javascript">
    $(function () {
        var check_type = function () {

            var v = $("#discharge_type").val();
            if(v == 'case'){
                $(".case").show();
                $(".Summary").hide();
            }else{
                $(".case").hide();
                $(".Summary").show();
            }
        }
        check_type();
        $("#discharge_type").change(function(){
            check_type();
        })
    })
</script>
@endsection