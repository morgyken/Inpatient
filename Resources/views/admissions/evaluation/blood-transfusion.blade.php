@extends('layouts.app')
@section('content_title','Blood Transfusion Management')
@section('content_description','Manage a patients blood transfusions')

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Transfusion Form  -->
@include('inpatient::admissions.evaluation.partials.transfusion.transfusion_form')

<!-- Transfusion Table -->
@include('inpatient::admissions.evaluation.partials.transfusion.transfusion_table')

@endsection