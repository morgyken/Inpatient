<?php
/*
 *  Collabmed Solutions Ltd
 *  Project: iClinic
 *  Author: Odhiambo Dormnic <dodhiambo@collabmed.com>
 */
?>

@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Admit Patients')

@section('content')
    <div class="box box-info">
        <div class="box-body">
            @if(! count($patients))
                <div class="alert text-warning">
                    <span>The are no patient recorded</span>
                </div>

            @else

                <table class="table table-stripped table-condensed">
                    <caption>The Patient List: All The Patients</caption>
                    <thead>
                    <th>ID/Passport</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Options</th>
                    </thead>
                    <tbody>
                    @foreach($patients as $patient)
                        <tr>
                            <td>{{$patient->id_no}}</td>
                            <td>{{($patient->full_name}}
                            </td>
                            <td>
                                {{(new Date($patient->created_at))->format('m/d/y')}}
                            </td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="{{url('inpatient/admission/admit/'.$patient->patient_id).'/'.$patient->visit_id}}">Admit</a>

                                <a class="btn btn-danger btn-xs" href="{{url('inpatient/admission/cancel/'.$patient->id).'/'.$patient->visit_id}}">Cancel Request</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            <script>
                $(function () {
                    $("table").dataTable();
                })
            </script>
        </div>
    </div>

@endsection
