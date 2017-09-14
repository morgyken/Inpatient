<?php
/*
 *  Collabmed Solutions Ltd
 *  Project: iClinic
 *  Author: David Ngugi <dngugi@collabmed.com>
 */
?>

@extends('layouts.app')
@section('content_title','All Patients')
@section('content_description','All Patients not admitted')

@section('content')
    @include('inpatient::includes.success')
    <div class="box box-info">
        <div class="box-body">
            @if(count($patients) < 0)
                <div class="alert text-warning">
                    <span>There are no patients recorded</span>
                </div>
            @else
                <table class="table table-stripped table-hover table-condensed">
                    <caption>The Patient list: All The Patients</caption>
                    <thead>
                        <th>ID/Passport</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                    @foreach($patients as $patient)
                        <tr>
                            <td>{{ $patient->id_no }}</td>
                            <td>{{ $patient->full_name }}</td>
                            <td>
                                {{ $patient->created_at->format('m/d/Y') }}
                            </td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="{{ url('inpatient/admit/'.$patient->id) }}">Admit</a>
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
