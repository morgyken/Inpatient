@extends('layouts.app')
@section('content_title','Inpatient Charges')
@section('content_description','Manage Inpatient Charges')

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Add an Inpatient Charge</h3>
    </div>
    <div class="box-body">
       
		@include('Inpatient::includes.success')

		<div class="row">
		    <div class="form-horizontal">
		        {!! Form::open(['url'=>'/inpatient/charges', 'method' => 'POST']) !!}
		        <div class="col-md-12">
		            <div class="col-md-6">
		                <div class="form-group {{  $errors->has('name') ? ' has-error' : ''  }} req">
		                    <label class="control-label col-md-4">Name</label>
		                    <div class="col-md-8">
		                        <input type="text" required name="name" class="form-control" />
		                        
		                    </div>
		                </div>
		                <div class="form-group {{  $errors->has('cost') ? ' has-error' : ''  }} req">
		                    <label class="control-label col-md-4">Amount</label>
		                    <div class="col-md-8">
		                         <input required  type="number" name="cost" class="form-control" />
		                    </div>
		                </div>
		            </div>

		            <div class="col-md-6">
		                <div class="form-group {{  $errors->has('type') ? ' has-error' : ''  }}">
		                    <label class="control-label col-md-4">Charge Type</label>
		                    <div class="col-md-8">
		                    	<select name="type" class="form-control" id="type" required>
		                            <option  value="once">One-Off Charge</option>
		                            <option value="recurring" selected>Recurring Charge</option>
		                        </select>
		                    </div>
		                </div>

		                 <div class="ward form-group {{  $errors->has('ward_id') ? ' has-error' : ''  }}">
		                    <label class="control-label col-md-4">Ward Number</label>
		                    <div class="col-md-8">
		                    <select name="ward_id[]" class="ward form-control" multiple="multiple">
		                            
		                           @foreach($wards as $ward)
		                            <option value="{{ $ward->id }}">{{ $ward->name }} - Ward No: {{ $ward->number }}</option>
		                           @endforeach()
		                        </select>
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
	        <div class="row">
	            <div class="col-md-12">
	                @if(!$charges->isEmpty())
		                <table class="table table-responsive table-striped">
		                	<thead>
		                        <tr>
		                            <th>Name</th>
		                            <th>Cost</th>
		                            <th>Type</th>
		                            <th>Added at</th>
		                            <th>Options</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        @foreach($charges as $charge)
		                            <tr>
		                                <td>{{ $charge->name }}</td>
		                                <td>{{ $charge->cost }}</td>
		                                <td>{{ $charge->type }}</td>
		                                <td>{{ $charge->created_at }}</td>
		                                <td>
		                                	<button class="btn btn-primary btn-xs"> <i class="fa fa-pencil"></i> Edit</button>
		                                    <a href="{{ url('/inpatient/delete_service/'.$charge->id) }}" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i> Delete</a>
		                                </td>
		                            </tr>
		                        @endforeach
		                    </tbody>
		                </table>
	                @else
		                <div class="alert alert-info">
		                    <p>No Nursing Charges</p>
		                </div>
	                @endif
	            </div>
	        </div>
	    </div>
	
	<script type="text/javascript">
	    $(document).ready(function () {
	        try { $('table').dataTable(); } catch (e) { }

	        var selBed = function () {
	            if($("#type").val() == 'recurring'){
		            $("div.ward").show();
		        }else{
		            $("div.ward").hide();
		        }
	        };

	        $("#type").change(function(){
	            selBed();
	        });

	        selBed();

	        $("select.ward").select2({
	            multiple:true,
	            placeholder:'Select one or more wards'
	        });
	    });
	</script>
@endsection