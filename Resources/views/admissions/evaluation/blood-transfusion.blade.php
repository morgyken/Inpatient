@extends('layouts.app')
@section('content_title','Prescriptions Management')
@section('content_description','Manage a patients prescriptions')

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Transfusion Form  -->
@include('inpatient::admissions.evaluation.partials.transfusion.transfusion_form')

<!-- Transfusion Table -->


@endsection