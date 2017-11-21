@extends('layouts.app')
@section('content_title','Blood Pressure Management')
@section('content_description','Manage a patients pressure')

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