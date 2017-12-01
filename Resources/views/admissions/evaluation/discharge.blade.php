@extends('layouts.app')
@section('content_title',"Patient Discharge Request")
@section('content_description', "Manage patient discharge")

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Discharge summary sheet -->
@include('inpatient::admissions.evaluation.partials.discharge.discharge_sheet')

@endsection