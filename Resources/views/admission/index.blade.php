@extends('layouts.app')
@section('content_title','Patient Admissions')
@section('content_description','All admitted patients')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Admissions</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if($admissions->count() > 0)
                    <table class="table table-stripped table-condensed">
                        <caption>Patient Admissions: All admitted patients in the hospital</caption>
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Admission Doctor</th>
                                <th>Ward</th>
                                <th>Bed Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach($admissions as $admission)
                                <tr>
                                    <td>{{ $admission->patient->full_name }}</td>
                                    <td>{{ $admission->doctor->profile->name }}</td>
                                    <td>{{ $admission->ward->name }}</td>
                                    <td>{{ $admission->bed->number }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs">Discharge</button>
                                        <button class="btn btn-danger btn-xs">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                <br/>
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Hey!</strong> Seems there are no patients admitted
                    </div>
                @endif

                {{-- @push('scripts') --}}
                    <script>
                        $(function () {
                            $("table").dataTable();
                        })
                    </script>
                {{-- @endpush --}}
            </div>
        </div>
    </div>
</div>
@stop