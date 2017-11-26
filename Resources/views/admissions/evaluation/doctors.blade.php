@extends('layouts.app')
@section('content_title',"Doctor's Notes Management")
@section('content_description', "Manage the doctor's notes")

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Main Content  -->
@include('inpatient::admissions.evaluation.partials.doctors.doctor_notes_form')

@endsection