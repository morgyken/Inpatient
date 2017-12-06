@extends('layouts.app')
@section('content_title','Patient Vitals Management')
@section('content_description','Manage the patient vitals')

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Include Patient Vitals Form -->
@include('inpatient::admissions.evaluation.partials.vitals.patient_vitals_form')

<!-- Include Patient Vitals Table -->
@include('inpatient::admissions.evaluation.partials.vitals.patient_vitals_table')

@endsection