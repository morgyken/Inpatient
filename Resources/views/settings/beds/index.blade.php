@extends('layouts.app')
@section('content_title','Add Bed')
@section('content_description','Allocate more beds to Existing wards')

@section('content')
    @include('Inpatient::includes.success')

<div class="box box-info">
    <div class="panel panel-info">
        <div class="panel-body">
            <div class="row">
            {!! Form::open(['url'=>'inpatient/beds','autocomplete'=>'off'])!!}
                <div class="form-group col-md-4">
                    <label>Enter Bed Number</label>
                    <input type="text" name="number" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>Choose Ward</label>
                    <select name="ward_id" class="form-control">
                        @foreach($wards as $ward)
                            <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Choose Bed Type</label>
                    <select name="bed_type_id" class="form-control">
                        @foreach($bedTypes as $bedType)
                            <option value="{{ $bedType->id }}">{{ $bedType->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group col-md-12">
                    <button class="btn btn-sm btn-primary col-md-2">Save Bed</button>
                </div>
            {!! Form::close()!!}        
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if($beds->count() > 0)
                        <table class="table table-stripped table-condensed">
                            <caption>The Beds List: All the beds listed in the system</caption>
                            <thead>
                                <tr>
                                    <th>Bed Number</th>
                                    <th>Ward</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach($beds as $bed)
                                    <tr>
                                        <td>{{ $bed->number }}</td>
                                        <td>{{ $bed->ward->name }}</td>
                                        <td>{{ $bed->type->name }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-xs">Remove Bed</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                    <br/>
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Hey!</strong> Seems there are no beds added yet
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
</div>
@endsection