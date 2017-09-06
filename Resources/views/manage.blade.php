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
    <div class="root"> </div>   
      
    <script src="{{ mix('js/app.js')}}" ></script>
    <script>
        $(function () {
            $("table").dataTable();
        })
    </script>
@endsection
