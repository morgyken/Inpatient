@extends('layouts.app')
@section('content_title',"Nurse's Notes Management")
@section('content_description', "Manage the murse's notes")

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Main Content Area -->
<div class="row">
    <div class="col-md-7">
        @include('inpatient::admissions.evaluation.partials.nurses.nurse_notes_form')
    </div>

    <div class="col-md-5">
        @include('inpatient::admissions.evaluation.partials.nurses.nurse_notes')
    </div>
</div>

<style>
    .items-container{
        height: 400px;
        overflow-y: scroll;
    }
</style>

@endsection