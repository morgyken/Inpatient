@extends('layouts.app')
@section('content_title','Prescriptions Management')
@section('content_description','Manage a patients prescriptions')

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Procedures Section  -->
@include('inpatient::admissions.evaluation.partials.procedures.procedures_form')

@endsection