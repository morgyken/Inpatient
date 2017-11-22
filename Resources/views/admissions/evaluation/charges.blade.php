@extends('layouts.app')
@section('content_title','Charge Sheet Management')
@section('content_description','View charges on patient')

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Include General Charges -->
@include('inpatient::admissions.evaluation.partials.charges.general_charges_table')

@endsection