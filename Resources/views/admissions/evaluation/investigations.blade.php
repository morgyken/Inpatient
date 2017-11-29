@extends('layouts.app')
@section('content_title',"Doctor's Notes Management")
@section('content_description', "Manage the doctor's notes")

@section('content')

    <!-- Include patient information -->
    @include('inpatient::admissions.evaluation.includes.admission_details')

    <!-- Include navigation -->
    @include('inpatient::admissions.evaluation.includes.evaluation_navigation')

    <!-- Investigations -->
    <div class="row">
        <div class="col-md-8">
            @include('inpatient::admissions.evaluation.partials.investigations.investigations_main')
        </div>
        <div class="col-md-4">
            @include('inpatient::admissions.evaluation.partials.investigations.investigations_selected')
        </div>
    </div>

    @include('inpatient::admissions.evaluation.partials.investigations.investigations_table')

    <style>
        .investigation_item {
            height: 400px;
            overflow-y: scroll;
        }
    </style>

    <script>
        var USER_ID = parseInt("{{ Auth::user()->id }}");
        var VISIT_ID = parseInt("{{ $admission->id }}");
        var DIAGNOSIS_URL = "{{ route('api.evaluation.save_diagnosis',['__inpatient'=>true]) }}";
        var THE_TABLE_URL = "{{ url('/api/inpatient/v1/get/inpatient-investigations/'.$admission->visit_id) }}";
        var THE_CONSUMABLE_URL = "{{ url('inpatient/evaluations/'.$visit->id.'/consumables') }}";
        var PERFOMED_INVESTIGATION_URL = "{{ route('api.evaluation.performed_investigations',$admission->visit_id) }}";

        $(document).ready(function () {
            $('.accordion').accordion({heightStyle: "content"});
        });
    </script>
    <script src="{!! m_asset('inpatient:js/doctor-investigations.js') !!}"></script>
@endsection