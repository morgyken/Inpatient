@extends('layouts.app')
@section('content_title','Prescriptions Management')
@section('content_description','Manage a patients prescriptions')

@section('content')

    <!-- Include patient information -->
    @include('inpatient::admissions.evaluation.includes.admission_details')

    <!-- Include navigation -->
    @include('inpatient::admissions.evaluation.includes.evaluation_navigation')

    <!-- Procedures Section  -->
    <div class="row">
        <div class="col-md-8">
            @include('inpatient::admissions.evaluation.partials.procedures.procedures_form')
        </div>
        <div class="col-md-4">
            @include('inpatient::admissions.evaluation.partials.procedures.selected')
        </div>
    </div>

    @include('inpatient::admissions.evaluation.partials.procedures.procedures_table')
    <style>
        #treatment_form {
            height: 400px;
            overflow-y: scroll;
        }

        .treatment_item {
            overflow-y: scroll;
        }
    </style>
    <script>
        var PERFOMED_URL = "{{ route('api.evaluation.performed_treatment',$visit->id) }}";
        $(document).ready(function () {
            $('.treatment_item').find('input').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
            $('.accordion').accordion({heightStyle: "content"});
        });
    </script>
    <script src="{!! m_asset('inpatient:js/doctor-treatment.js') !!}"></script>
@endsection