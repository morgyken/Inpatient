@extends('layouts.app')
@section('content_title','Prescriptions Management')
@section('content_description','Dispense a patients drugs')

@section('content')
<!-- Include panel for dispensing the drugs -->
@include('inpatient::admissions.evaluation.partials.prescriptions.dispense')

@endsection