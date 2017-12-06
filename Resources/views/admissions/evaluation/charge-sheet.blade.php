@extends('layouts.app')
@section('content_title','Charge Sheet Management')
@section('content_description','View charges on patient')

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Include Charge Sheets Here -->
@include('inpatient::admissions.evaluation.partials.charges.admission_charges')

@include('inpatient::admissions.evaluation.partials.charges.ward_charges')

@include('inpatient::admissions.evaluation.partials.charges.consumable_charges')

@include('inpatient::admissions.evaluation.partials.charges.prescription_charges')




@endsection