@extends('layouts.app')
@section('content_title','Drugs Administration')
@section('content_description','Administer prescribed medication')

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Administer Form  -->
@include('inpatient::admissions.evaluation.partials.administer.administer_form')

@endsection