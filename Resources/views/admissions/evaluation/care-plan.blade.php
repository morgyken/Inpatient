@extends('layouts.app')
@section('content_title',"Care Plan Management")
@section('content_description', "Manage the nursing care plans")

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Include the care plan form -->
@include('inpatient::admissions.evaluation.partials.care.care_plan_form')

<!-- Include the care plan table -->
@include('inpatient::admissions.evaluation.partials.care.care_plan_table')

@endsection