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
@section('content_title','Requested Discharges')
@section('content_description','Manage Discharges')

@section('content')




<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Requested Discharges</h3>
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

        


        <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$discharges->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($discharges as $d)
                            <tr>
                                <td>
                                 {{ $d->admission->patient->fullname}}</td>
                                <td>
                                    @if($d->admission->external_doctor != null)
                                        {{ $d->admission->external_doctor }}
                                    @else
                                        {{ $d->admission->doctor->profile->fullName }}
                                    @endif
                                </td>
                                <td>{{ $d->status }}</td>
                                <td>{{ $d->created_at->format('d/m/y h:i a') }}</td>
                                <td>
                                    <a href="{{url('inpatient/discharge/'.$d->id)}}" class="btn btn-primary btn-xs">Discharge</a>
                                     <a href="{{url('inpatient/Cancel_discharge/'.$d->id)}}" class="btn btn-danger btn-xs">Cancel Request</a>
                                </td>
                            </tr>
                        @endforeach()
                    </tbody>
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>status</th>
                            <th>Added at</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No Requested Discharges</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script src="{{m_asset('reception:js/addpatient.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('table').dataTable();
        } catch (e) {
        }
        var selBed = function () {
            if($("#type").val() == 'nursing'){
            $("div.ward").show();
        }else{
            $("div.ward").hide();
        }
        };

        $("#type").change(function(){
            selBed();
        });
        selBed();
    });
</script>
@endsection