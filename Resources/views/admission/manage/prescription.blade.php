<div role="tabpanel" id="prescription" class="tab-pane fade">
    <h3 class="text-center">Request and Administer Prescriptions</h3>
	{!! Form::open(['class'=>'form-horizontal', 'url'=>'inpatient/evaluate/prescriptions']) !!}
		<input type="hidden" name="admission_id" value="{{ $admission->id }}" required>
		<table class="table" style="width: 100%">
		    <tr>
		        <th>Drug</th>
		        <td><select name="drug" id="item_0" class="form-control select2-single" style="width: 100%" required></select></td>
		    </tr>
		    <tr>
		        <th>Dose</th>
		        <td>
			        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
			        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 !important;">
			        		<input type="text" name="take" id="take" class="form-control" required />
			        	</div>
		            	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 !important;">
		            		{!! Form::select('whereto',mconfig('evaluation.options.prescription_whereto'),null,['class'=>'form-control', 'id' => 'whereto'])!!}
		            	</div>
		            	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 !important;">
		            		{!! Form::select('method',mconfig('evaluation.options.prescription_method'),null,['class'=>'form-control', 'id' => 'method'])!!}
		            	</div>
		            </div>
		        </td>
		    </tr>
		    <tr>
		        <th>Duration</th>
		        <td>
		        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
		        		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding: 0 !important;">
		        			 <input type="text" name="duration" id = "duration" placeholder="E.g 3" class='form-control' required />
		        		</div>
		        		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding: 0 !important;">
		        			{!! Form::select('time_measure',mconfig('evaluation.options.prescription_duration'),null,['class'=>'form-control', 'id' => 'time_measure'])!!}
		        		</div>
		        	</div>
		        </td>
		    </tr>
			<tr>
				<th>Units to Dispense</th>
				<td>
					<div class="form-group">
						<div class="col-md-8">
							{{Form::text('quantity',1,['class'=>'form-control'])}}
						</div>
					</div>
				</td>
			</tr>
		</table>
		<button type="button" class="btn btn-lg btn-primary " id="savePrescription">
		    <i class="fa fa-save"></i> Save
		</button>
	{!! Form::close() !!}

	<br/>
	{{-- <div class="alerts-prescriptions"></div> --}}
	

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3>ONCE ONLY PRESCRIPTIONS, STAT DOSES, PRE-MED Etc.</h3>
		<div class="table-responsive">
			<table class="table table-stripped" id = "single-prescriptions-table">
		    	<thead>
		    		<tr>
		    			<th>Drug</th>
		    			<th>Dosage & Duration</th>
		    			<th>Prescribed By</th>
		    			<th>Prescribed On</th>
		    		</tr>
		    	</thead>
		    	<tbody>
		    		@foreach($once_only_prescriptions as $p)
		    			<tr id = "once_row_{{ $p->id }}">
		    				<td>{{ $p->drugs->name }}</td>
		    				<td>{{ $p->dose }}</td>
		    				<td>{{ $p->users->profile->fullName }}</td>
		    				<td>{{ \Carbon\Carbon::parse($p->updated_at)->format('H:i A d/m/Y ')}}</td>
		    				<td>
			    				@if($p->status == 1)
			    					<div class='btn-group'>
			    						@if(\Ignite\Inpatient\Entities\Administration::where("prescription_id", $p->id)->count() <= 0)
			    							<button class='btn btn-primary administer-once' id = '{{ $p->id }}'><i class = 'fa fa-plus'></i> Administer</button>
			    						@endif
			    						<button type='button' class='btn btn-success view-logs' id = '{{ $p->id }}'><i class = 'fa fa-eye'></i> View</button>
			    						@if($p->stopped == 0)
			    							<button type='button' class='btn btn-info stop-o-prescription' id = '{{ $p->id }}'><i class = 'fa fa-times' ></i> Stop</button>
			    						@else
			    							<button type='button' class='btn btn-info stopped-o-prescription' id = '{{ $p->id }}'><i class = 'fa fa-exclamation-circle' ></i> Stopped</button>
			    						@endif
				    					<button type='button' class='btn btn-danger cancel-o-prescription' id = '{{ $p->id }}'><i class = 'fa fa-times' ></i> Cancel</button>
				    				</div>
				    			@else
				    				<div class='btn-group'>
				    					<button type='button' class='btn btn-info'><i class = 'fa fa-exclamation-circle'></i> Dispensing</button>
					    				<button type='button' class='btn btn-danger cancel-o-prescription' id = '{{ $p->id }}'><i class = 'fa fa-times' ></i> Cancel</button>
				    				</div>
			    				@endif
			    			</td>
		    			</tr>
		    		@endforeach
		    	</tbody>
		    </table>
	    </div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3>REGULAR PRESCRIPTIONS</h3>	
		<div class="table-responsive">
		    <table class="table table-stripped" id = "regular-prescriptions-table">
		    	<thead>
		    		<tr>
		    			<th>Drug</th>
		    			<th>Dosage & Duration</th>
		    			<th>Prescribed By</th>
		    			<th>Prescribed On</th>
		    			<th>Options</th>
		    		</tr>
		    	</thead>
		    	<tbody>
		    		@foreach($regular_prescriptions as $p)
		    			<tr id = "reg_row_{{ $p->id }}">
		    				<td>{{ $p->drugs->name }}</td>
		    				<td>{{ $p->dose }}</td>
		    				<td>{{ $p->users->profile->fullName }}</td>
		    				<td>{{ $p->updated_at->format('H:i A d/m/Y ')}}</td>
		    				<td>
		    					@if($p->status == 1)
			    					<div class='btn-group'>
				    					<button class='btn btn-primary administer' id = '{{ $p->id }}'><i class = 'fa fa-plus'></i> Administer</button>
				    					<button type='button' class='btn btn-success view-logs' id = '{{ $p->id }}'><i class = 'fa fa-eye'></i> View</button>
				    					@if($p->stopped == 0)
			    							<button type='button' class='btn btn-info stop-reg-prescription' id = '{{ $p->id }}'><i class = 'fa fa-times' ></i> Stop</button>
			    						@else
			    							<button type='button' class='btn btn-info stopped-reg-prescription' id = '{{ $p->id }}'><i class = 'fa fa-exclamation-circle' ></i> Stopped</button>
			    						@endif
				    					<button type='button' class='btn btn-danger cancel-reg-prescription' id = '{{ $p->id }}'><i class = 'fa fa-times' ></i> Cancel</button>
				    				</div>
				    			@else
				    				<div class='btn-group'>
				    					<button type='button' class='btn btn-info'><i class = 'fa fa-exclamation-circle'></i> Dispensing</button>
				    					<button type='button' class='btn btn-danger cancel-reg-prescription' id = '{{ $p->id }}'><i class = 'fa fa-times' ></i> Cancel</button>
				    				</div>
			    				@endif
			    			</td>
		    			</tr>
		    		@endforeach
		    	</tbody>
		    </table>
	    </div>
    </div>

    {{-- MODALS --}}

	<div class="modal fade" id="modal-id">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Administer Prescription</h4>
				</div>
				<div class="modal-body">
					<form role="form">
						{{ csrf_field() }}
						<input type = "hidden" name = "prescription_id" id = "prescription_id"/>
						<div class="form-group">
							<label>Time Administered</label>
							<input type="text" name = "time" id = "time" class="form-control" placeholder="Time" required/>
						</div>
						<button type="button" class="btn btn-primary" id = "administer_drug">Administer</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-view">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Prescription Administration Logs</h4>
				</div>
				<div class="modal-body">
					<div class="table-responsive" style="max-height: 500px;">
						<table class="table table-hover" id = "admin-logs-table">
							<thead>
								<tr>
									<th>Prescription Dose</th>
									<th>Administered By</th>
									<th>Administered On</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-cancel-prescription">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3>Are you sure you want to cancel this prescription?</h3>
                    <input type="hidden" id = "is_reg" />
                    <label>If yes, you must provide a reason below</label>
                    <textarea name="cancel_reasons" id="cancel_reasons" class="form-control" rows="3" cols = "10" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger yes-cancel-prescription">Yes</button>
                    <button type="button" class="btn btn-success" id = "no-cancel-prescription"  data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-stop-prescription">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3>Are you sure you want to stop this prescription?</h3>
                    <input type="hidden" id = "is_stop_reg" />
                    <label>If yes, you must provide a reason below</label>
                    <textarea name="stop_reasons" id="stop_reasons" class="form-control" rows="3" cols = "10" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger yes-stop-prescription">Yes</button>
                    <button type="button" class="btn btn-success" id = "no-stop-prescription"  data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    {{-- END MODALS --}}


    {{-- SCRIPTS --}}
	<script>
	    var INSURANCE = false;
	    var STOCK_URL = "{{route('api.inventory.getstock')}}";
	    var PRODUCTS_URL = "{{route('api.inventory.get.products')}}";
	    var VISIT_ID = "{{ $admission->visit_id }}";
	    var ADMISSION_ID = "{{ $admission->id }}";
	    var USER_ID = "{{ Auth::user()->id }}";
	    var PRESCRIPTIONS_URL = "{{ url('/api/inpatient/v1/prescriptions') }}";
	    var PRESCRIPTIONS_DELETE_URL = "{{ url('/api/inpatient/v1/prescriptions/delete') }}";
	    var PRESCRIPTIONS_STOP_URL = "{{ url('/api/inpatient/v1/prescriptions/stop') }}";
	    var ADMINISTER_PRESCRIPTION_URL = "{{ url('/api/inpatient/v1/prescriptions/administer') }}";
	    var GET_LOGS_URL = "{{ url('/api/inpatient/v1/prescriptions/administration')}}";
	    var DELETE_ADMINISTRATION_URL = "{{ url('/api/inpatient/v1/prescriptions/administration/delete') }}";
	</script>
	<script src="{!! m_asset('evaluation:js/prescription.js') !!}"></script>

</div>
