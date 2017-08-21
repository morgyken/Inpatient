<div id="prescription" class="tab-pane fade">
    <h3>Prescription 
    {{-- <small><a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Add prescription</a></small> --}}
	</h3>
	{!! Form::open(['class'=>'form-horizontal', 'route'=>'evaluation.evaluate.pharmacy.prescription']) !!}
		<input type="hidden" name="visit" value="{{ $admission->visit_id }}">
		<table class="table" style="width: 70%">
		    <tr>
		        <th>Drug</th>
		        <td><select name="drug" id="item_0" class="form-control select2-single" style="width: 100%" required></select></td>
		    </tr>
		    <tr>
		        <th>Dose</th>
		        <td>
			        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
			        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 !important;">
			        		<input type="text" name="take" id="Take" class="form-control"/>
			        	</div>
		            	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 !important;">
		            		{!! Form::select('whereto',mconfig('evaluation.options.prescription_whereto'),null,['class'=>'form-control'])!!}
		            	</div>
		            	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 !important;">
		            		{!! Form::select('method',mconfig('evaluation.options.prescription_method'),null,['class'=>'form-control'])!!}
		            	</div>
		            </div>
		        </td>
		    </tr>
		    <tr>
		        <th>Duration</th>
		        <td>
		        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
		        		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding: 0 !important;">
		        			 <input type="text" name="duration" placeholder="E.g 3" class='form-control'/>
		        		</div>
		        		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding: 0 !important;">
		        			{!! Form::select('time_measure',mconfig('evaluation.options.prescription_duration'),null,['class'=>'form-control'])!!}
		        		</div>
		        	</div>
		        </td>
		    </tr>
		    <tr>
		        <th>Substitution Allowed?</th>
		        <td>
		            Yes <input type="checkbox" name="allow_substitution" value="1"/>
		        </td>
		    </tr>
		</table>
		<button type="submit" class="btn btn-medium btn-primary " id="savePrescription">
		    <i class="fa fa-save"></i> Save
		</button>
	{!! Form::close() !!}

    <table class="table table-hover">
    	<thead>
    		<tr>
    			<th>Drug</th>
    			<th>Dosage & Duration</th>
    			<th>Prescribed By</th>
    			<th>Prescribed On</th>
    		</tr>
    	</thead>
    	@if(count($prescriptions) > 0)
    	<tbody>
    	
    		@foreach($prescriptions as $p)
    		<tr>
    			<td>{{ $p->drug }}</td>
    			<td>{{ $p->dose }}</td>
    			<td>{{ $p->users->full_name }}</td>
    			<td>{{ \Carbon\Carbon::parse($p->created_at)->format('ds M,Y') }}</td>
    		</tr>
    		@endforeach
    	</tbody>
    	@else
    		<div class="alert alert-info" style="padding-top: 10px !important;">
    			 There are no previous prescriptions for this patient
    		</div>
    	@endif
    </table>
</div>

{{-- <div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add a prescription</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div> --}}

<script>
    var INSURANCE = false;
    var STOCK_URL = "{{route('api.inventory.getstock')}}";
    var PRODUCTS_URL = "{{route('api.inventory.get.products')}}";
</script>
<script src="{!! m_asset('evaluation:js/prescription.js') !!}"></script>