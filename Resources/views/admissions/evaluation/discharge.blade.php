@extends('layouts.app')
@section('content_title',"Patient Discharge Request")
@section('content_description', "Manage patient discharge")

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Discharge summary sheet -->
@include('inpatient::admissions.evaluation.partials.discharge.discharge_sheet')

<!-- Discharge prescription form -->
@include('inpatient::admissions.evaluation.partials.discharge.discharge_prescriptions_form')

<!-- Discharge prescription table -->
@include('inpatient::admissions.evaluation.partials.discharge.discharge_prescriptions_table')

{{-- @push('scripts') --}}
<script>
    var PRESCRIPTIONS_ENDPOINT = "{{ url('inpatient/evaluations/'.$visit->id.'/prescriptions') }}";
</script>
{{-- @endpush --}}

@endsection