@extends('layouts.app')
@section('content_title','Add Bed Types')
@section('content_description','Define bed types available')

@section('content')
@include('Inpatient::includes.success')

<div class="box box-info">
    <div class="panel panel-info">
        <div class="panel-body">
            <div class="row">
            {!! Form::open(['url'=>'inpatient/bed-types', 'autocomplete'=>'off'])!!}
                <div class="form-group col-md-6 req">
                    <label>Enter Bed Type</label>
                    <input type="text" name="name" class="form-control" required />
                </div>

                <div class="form-group col-md-6">
                    <label>Enter Description</label>
                    <textarea type="text" name="description" class="form-control"></textarea>
                </div>
                
                <div class="form-group col-md-12">
                    <button class="btn btn-sm btn-primary col-md-2">Save Bed Type</button>
                </div>
            {!! Form::close()!!}        
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if($bedTypes->count() > 0)
                        <table class="table table-stripped table-condensed">
                            <caption> All the beds types set the system</caption>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Total</th>
                                    <th>Occupied</th>
                                    <th>Available</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach($bedTypes as $bedType)
                                    <tr>
                                        <td>{{ $bedType->name }}</td>
                                        <td>{{ $bedType->description }}</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>
                                            <a href="{{ url('inpatient/bed-types/delete/'.$bedType->id) }}" class="btn btn-danger btn-xs">
                                                Remove Bed Type
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                    <br/>
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Oops!</strong> Seems there are no bed types added yet
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