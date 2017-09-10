<div role="tabpanel" id="prescription" class="tab-pane fade">
    <h3 class="text-center">Request and Administer Prescriptions</h3>
	{{-- {!! Form::open(['class'=>'form-horizontal', 'route'=>'evaluation.evaluate.pharmacy.prescription']) !!} --}}
	<form>
		{{ csrf_field() }}
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
		        <th>Substitution Allowed?</th>
		        <td style="font-size:1.5em;">
		            Yes <input type="checkbox" name="allow_substitution" id = "allow_substitution" style="width: 100px !important;" required />
		        </td>
		    </tr>

		    <tr>
		        <th>Regular prescription?</th>
		        <td style="font-size:1.5em;">
		            Yes <input type="checkbox" name="type" id = "type" style="width: 100px !important;" required />
		        </td>
		    </tr>
		</table>
		<button type="submit" class="btn btn-lg btn-primary " id="savePrescription">
		    <i class="fa fa-save"></i> Save
		</button>
	</form>

	<br/>
	{{-- <div class="alerts-prescriptions"></div> --}}
	

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3>ONCE ONLY PRESCRIPTIONS, STAT DOSES, PRE-MED Etc.</h3>
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
		    						<button class='btn btn-primary administer-once' id = '{{ $p->id }}'><i class = 'fa fa-plus'></i> Administer</button>
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

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3>REGULAR PRESCRIPTIONS</h3>	
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
	    				<td>{{ \Carbon\Carbon::parse($p->updated_at)->format('H:i A d/m/Y ')}}</td>
	    				<td>
	    					@if($p->status == 1)
		    					<div class='btn-group'>
			    					<button class='btn btn-primary administer' id = '{{ $p->id }}'><i class = 'fa fa-plus'></i> Administer</button>
			    					<button type='button' class='btn btn-success view-logs' id = '{{ $p->id }}'><i class = 'fa fa-eye'></i> View</button>
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

    {{-- MODALS --}}

	<div class="modal fade" id="modal-id">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Prescribe Prescription</h4>
				</div>
				<div class="modal-body">
					<form role="form">
						{{ csrf_field() }}
						<input type = "hidden" name = "prescription_id" id = "prescription_id"/>
						<div class="form-group">
							<label>Time Administered</label>
							<input type="time" name = "time" id = "time" class="form-control" placeholder="Time" required/>
						</div>
						<div class="form-group">
							<label>AM or PM</label>
							<select name="am_pm" id="am_pm" class="form-control" required>
								<option value="am">AM</option>
								<option value ="pm">PM</option>
							</select>
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
							<tbody>
								
							</tbody>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger yes-cancel-prescription">Yes</button>
                    <button type="button" class="btn btn-success" id = "no-cancel-prescrption"  data-dismiss="modal">No</button>
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
	</script>
	<script src="{!! m_asset('evaluation:js/prescription.js') !!}"></script>

	<script type="text/javascript">

		$(document).ready(function(){
			// $(function () {
		 //        $("table").dataTable();
		 //    });

		    getTime();

			function getTime(){
				var d = new Date();
				let timeNow = d.getHours() + ':' + d.getMinutes();
				$("#time").val(timeNow);
				if( d.getHours() >= 12) {
					$("am_pm").val("pm").prop("selected", true);
				}else{
					$("am_pm").val("am").prop("selected", true);
				}
			}

	        $('.administer').click(function(e){
	        	e.preventDefault();
	        	var id = $(this).attr('id');
	        	getTime();
	        	$("#prescription_id").val(id);
				$("#modal-id").modal();			
			});

	        $('#savePrescription').click(function(e){
	            e.preventDefault();
	            let pre_type = ($("#type").is(":checked")) ? 1 : 0;
	            let data = JSON.stringify(
	            		{
	                     	visit : {{ $admission->visit_id }},
	                     	admission_id: {{ $admission->id }},
	                    	user: {{ Auth::user()->id }},
							drug: $("#item_0").val(),
							take: parseInt($("#take").val()),
							whereto: parseInt($("#whereto").val()),
							method: parseInt($("#method").val()),
							duration: parseInt($("#duration").val()),
							time_measure: parseInt($("#time_measure").val()),
							allow_substitution: $("#allow_substitution").is(":checked"),
	                     	type: pre_type
	               		});

	             $.ajax({
	                type: "POST",
	                url: "{{ url('/api/inpatient/v1/prescriptions') }}",
	                data: data,
	                success: function (resp) {
	                    // add table rows
	                     if(resp.type === "success"){
	                     	alertify.success(resp.message);
	                     	// Append to Respective row
	   						let data = resp.data;
	                        // console.log(resp.data);
	                     	if(pre_type == 0){
	                     		// Append to Once only prescription table
	                            data.map( (item, index) => {
	                                return(
	                                    $("#single-prescriptions-table > tbody").append("<tr id = 'once_row_"+ item.id +"'>\
	                                    	<td>"+ item.drug +"</td>\
	                                        <td>" + item.dose + "</td>\
	                                        <td>"+ item.prescribed_by +"</td>\
	                                        <td>"+ item.prescribed_on +"</td>\
	                                        <td><div class='btn-group'>\
					    					<button type='button' class='btn btn-info'><i class = 'fa fa-exclamation-circle'></i> Dispensing</button>\
						    				<button type='button' class='btn btn-danger cancel-o-prescription' id = '"+ item.id +"'><i class = 'fa fa-times' ></i> Cancel</button>\
					    				</div></td></tr>")
	                                ); 
	                            });
	                     	}else{
	                     		// Append to Regular prescription table
	                            data.map( (item, index) => {
	                                return(
	                                    $("#regular-prescriptions-table > tbody").append("<tr id = 'reg_row_"+ item.id +"'>\
	                                    	<td>"+ item.drug +"</td>\
	                                        <td>" + item.dose + "</td>\
	                                        <td>"+ item.prescribed_by +"</td>\
	                                        <td>"+ item.prescribed_on +"</td>\
	                                        <td><div class='btn-group'>\
					    					<button type='button' class='btn btn-info'><i class = 'fa fa-exclamation-circle'></i> Dispensing</button>\
					    					<button type='button' class='btn btn-danger cancel-reg-prescription' id = '"+ item.id +"'><i class = 'fa fa-times' ></i> Cancel</button>\
					    				</div></td></tr>")
	                                );
	                            });
	                     	}
	                        alertify.success(resp.message);
	                    }else{
	                    	 alertify.error(resp.message);
	                    }
	                },
	                error: function (resp) {
	                    alertify.error(resp.message);
	                }
	            });
	        });

	        $('.cancel-o-prescription').click(function(e){
	        	e.preventDefault();
	        	let id =  $(this).attr('id');
	        	$(".yes-cancel-prescription").attr('id', id); 
	        	$("#is_reg").val(0); 
                $("#modal-cancel-prescription").modal();
	        });

	         $('.cancel-reg-prescription').click(function(e){
	        	e.preventDefault();
	        	let id =  $(this).attr('id');
	        	$(".yes-cancel-prescription").attr('id', id); 
	        	$("#is_reg").val(1); 
                $("#modal-cancel-prescription").modal();
	        });

	        $('.yes-cancel-prescription').click(function(e){
                var id = $(this).attr('id');
                var type = parseInt($("#is_reg").val());
                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/prescriptions/delete') }}",
                    data: JSON.stringify({ id : id }),
                    success: function (resp) {
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            if(type == 1){
                            	$("#reg_row_"+id+"").remove();
                        	}else if(type == 0){
                        		$("#once_row_"+id+"").remove();
                        	}
                        	$("#modal-cancel-prescription").modal('toggle');
                        }else{
                             alertify.error(resp.message);
                        }
                    },
                    error: function (resp) {
                        alertify.error(resp.message);
                    }
                });
            });


	        $('#administer_drug').click(function(e){
	        	e.preventDefault();
				
				let data = JSON.stringify({ 
					admission_id : {{ $admission->id }},
					prescription_id : $("#prescription_id").val(),
					visit_id : {{ $admission->visit_id }},
					time : $("#time").val(),
					am_pm : $("#am_pm").val(),
					user: {{ Auth::user()->id }}
				});

	        	$.ajax({
	                type: "POST",
	                url: "{{ url('/api/inpatient/v1/prescriptions/administer') }}",
	                data: data,
	                success: function (resp) {
	                     if(resp.type === "success"){
	                        alertify.success(resp.message);
	                        $("#modal-id").modal();
	                    }else{
	                    	 alertify.error(resp.message);
	                    }
	                },
	                error: function (resp) {
	                    alertify.error(resp.message);
	                }
	            });

	        });

	        function getLogs(id){
	        	$.ajax({
			        type: "GET",
			        url: "{{ url('/api/inpatient/v1/prescriptions/administration')}}/"+ id +"",
			        dataType: 'json',
			        success: function (resp) {                
			            if(resp.type === "success"){
			                if(resp.data.length > 0){
			                    // refresh table
			                    $("#admin-logs-table > tbody tr").remove();
			                    // Loop through and append rows
			                    let data = resp.data;
		                    	data.map( (item, index) => {
		                            return(
		                                $("#admin-logs-table > tbody").append(
		                                	"<tr id = 'row_"+ item.id +"'>\
								    			<td>" + item.dose + "</td>\
								    			<td>" + item.recorded_by + "</td>\
								    			<td>" + item.recorded_on + "</td>\
								    			<td><button type='button' class='btn btn-danger delete-log' id = '"+ item.id+"'><i class = 'fa fa-times' ></i> Delete</button>\
								    			</td>\
								    		</tr>"
		                                )
		                            );
		                        });

		                        $("#modal-view").modal();

			                }else{
			                    alertify.error("No administration logs found for this patient");
			                }
			            }else{
			                alertify.error(resp.message);
			            }
			           
			        },
			        error: function (resp) {
			        	alertify.error(resp.message);
			        }
			    });
	        }

	        $('.view-logs').click(function(e){
	        	e.preventDefault();
	        	var id = $(this).attr('id');
	        	getLogs(id);
	        });


	        $('.delete-log').click(function(e){
	        	e.preventDefault();
				var id = $(this).attr('id');
				let data = JSON.stringify({ id : id });
	        	$.ajax({
	                type: "POST",
	                url: "{{ url('/api/inpatient/v1/prescriptions/administration/delete') }}",
	                data: data,
	                success: function (resp) {
	                     if(resp.type === "success"){
	                        alertify.success(resp.message);
	                        $("#admin-logs-table > tbody #row_"+id+"").remove();
	                    }else{
	                    	 alertify.error(resp.message);
	                    }
	                },
	                error: function (resp) {
	                    alertify.error(resp.message);
	                }
	            });

	        });


	    });

	</script>

</div>