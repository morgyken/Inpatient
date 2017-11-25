@extends('layouts.app')
@section('content_title',"Doctor's Notes Management")
@section('content_description', "Manage the doctor's notes")

@section('content')

<!-- Include patient information -->
@include('inpatient::admissions.evaluation.includes.admission_details')

<!-- Include navigation -->
@include('inpatient::admissions.evaluation.includes.evaluation_navigation')

<!-- Main Content  -->
<div class="row">
    <div class="col-md-8">
        @include('inpatient::admissions.evaluation.partials.consumables.consumables_form')
    </div>
    <div class="col-md-4">
        @include('inpatient::admissions.evaluation.partials.consumables.consumables_pick')
    </div>
</div>

<!-- Selected Consumables Table -->
<div class="row">
    <div class="col-md-12">
        @include('inpatient::admissions.evaluation.partials.consumables.consumables_table')
    </div>
</div>

<style>
    .consumable_item {
        height: 400px;
        overflow-y: scroll;
    }
</style>

<!-- Start Scripts -->
{{-- @push('scripts') --}}
<script>
    var USER_ID = parseInt("{{ Auth::user()->id }}");
    var VISIT_ID = parseInt("{{ $visit->id }}");
    var CONSUMABLE_URL = "{{url('api/inpatient/v1/saver/consumables')}}";
    var THE_CONSUMABLE_URL = "{{url('/api/inpatient/v1/get/inpatient-consumables/'.$admission->visit_id)}}";
    $(document).ready(function () {
        $('#consumableTab input').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
{{-- @endpush --}}
<!-- End Scripts -->

@endsection