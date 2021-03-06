@extends('layouts.app')
@section('content_title',"Patients Temperature Management")
@section('content_description', "Manage patient's temperature")

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Include tht blood pressure chart -->
@include('inpatient::admissions.evaluation.partials.graphs.temperature')

@endsection