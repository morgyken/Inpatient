@extends('layouts.app')
@section('content_title','Add Bed Type')
@section('content_description','Add more bed types to existing list')

@section('content')
    @include('Inpatient::includes.success')

    <div class="box box-info">
        <div class="box-body">
            
            <div class="row">
            	<div class="form-horizontal">
                    {!! Form::open(['url'=>'/inpatient/beds/type/add']) !!}
	                    <div class="col-md-12">
	                        <div class="col-md-6">
	                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
	                                <label class="control-label col-md-4">Bed Type</label>
	                                <div class="col-md-8">
	                                     <input type="text" name="name" id = "name" class="form-control" autofocus required />
	                                </div>
	                            </div>
	                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
	                                <label class="control-label col-md-4">Description</label>
	                                <div class="col-md-8">
	                              		<textarea name="description" id="description" class="form-control" rows="3" cols="8" required></textarea>
	                                </div>
	                            </div>
	                            <div class="pull-right">
	                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
	                            </div>
	                        </div>
	                    </div> 
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="box-body">
            	<table class="table table-hover">
            		<thead>
            			<tr>
            				<th>Bed Type</th>
            				<th>Description</th>
            				<th>Added On</th>
            				<th>Option</th>
            			</tr>
            		</thead>
            		<tbody>
            			@foreach($bedTypes as $b)
	            			<tr>
	            				<td>{{ ucwords($b->name) }}</td>
	            				<td>{{ ucfirst($b->description) }}</td>
	            				<td>{{ $b->created_at->format('d/m/Y H:i a') }}</td>
	            				<td><a href="{{url('/inpatient/beds/type/'.$b->id.'/delete')}}" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</a></td>
	            			</tr>
            			@endforeach
            		</tbody>
            	</table>
            </div>

        </div>
    </div>
@endsection