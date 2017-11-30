@extends('layouts.app')
@section('content_title',"Doctor's Notes Management")
@section('content_description', "Manage the doctor's notes")

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Main Content Area -->
<div class="row">
    <div class="col-md-7">
        @include('inpatient::admissions.evaluation.partials.doctors.doctor_notes_form')
    </div>

    <div class="col-md-5">
        @include('inpatient::admissions.evaluation.partials.doctors.doctor_notes')
    </div>
</div>

<style>
    .items-container{
        height: 400px;
        overflow-y: scroll;
    }
</style>

@endsection