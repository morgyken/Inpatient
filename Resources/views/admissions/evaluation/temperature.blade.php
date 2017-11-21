@extends('layouts.app')
@section('content_title','Body Temperature Management')
@section('content_description','Manage a patient's temperature')

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<div class="box box-info">
    <div class="box-body">

    <!-- Include navigation -->
    @include('inpatient::admissions.evaluation.includes.evaluation_navigation')

    <!-- Main Content  -->


    </div>
</div>
@endsection