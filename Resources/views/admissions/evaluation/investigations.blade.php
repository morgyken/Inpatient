@extends('layouts.app')
@section('content_title','Investigations Management')
@section('content_description','Manage investigations done on patient')

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