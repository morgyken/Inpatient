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
		 <table class="table table-hover datatable" id = "single-prescriptions-table" style="display:none !important;">
	    	<thead>
	    		<tr>
	    			<th>Drug</th>
	    			<th>Dosage & Duration</th>
	    			<th>Prescribed By</th>
	    			<th>Prescribed On</th>
	    		</tr>
	    	</thead>
	    	<tbody></tbody>
	    </table>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3>REGULAR PRESCRIPTIONS</h3>	
	    <table class="table table-hover datatable" id = "regular-prescriptions-table" style="display:none !important;">
	    	<thead>
	    		<tr>
	    			<th>Drug</th>
	    			<th>Dosage & Duration</th>
	    			<th>Prescribed By</th>
	    			<th>Prescribed On</th>
	    			<th>Options</th>
	    		</tr>
	    	</thead>
	    	<tbody></tbody>
	    </table>
    </div>

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
						<select name="am_pm" name = "am_pm" id="am_pm" class="form-control" required>
							<option value="am">AM</option>
							<option value ="pm">PM</option>
						</select>
					</div>				
					<button type="button" class="btn btn-primary administer_drug">Administer</button>
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
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Prescription</th>
								<th>Date & Time</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>11 am</td>
								<td>12 am</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
{{-- 				<button type="button" class="btn btn-primary">Save changes</button>
 --}}				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

	<script>
	    var INSURANCE = false;
	    var STOCK_URL = "{{route('api.inventory.getstock')}}";
	    var PRODUCTS_URL = "{{route('api.inventory.get.products')}}";
	</script>
	<script src="{!! m_asset('evaluation:js/prescription.js') !!}"></script>

	<script type="text/javascript">

		$(document).ready(function(){
			// $(function () {
		 //        $(".datatable").dataTable();
		 //    });
			
			getTime();
			setInterval( getTime , 1000);

			var timeSet = false;
		    function getTime(){ 
		    	var d = new Date();
		    	// d.setUTCHours(d.getHours(), d.getMinutes(), d.getSeconds(), 0);
				let timeNow = d.getHours() + ':' + d.getMinutes();
				if(timeSet == false) { $("#time").val(timeNow); }
				timeSet = true;
			}

			$('.administer').on('click', function(){
				
			});

			function showModal(id){
				$("#modal-id").show();
				$("#prescription_id").val(id);
			}
			
			// Get once only prescriptions 
			getPrescriptions(0);

			// Get regular prescriptions
			getPrescriptions(1);

			function getPrescriptions(type){
					let table = (type == 0) ? "#single-prescriptions-table" :  "#regular-prescriptions-table";
		            $.ajax({
		                type: "GET",
		                url: "{{ url('/api/inpatient/v1/prescriptions/admission/'.$admission->id).'/type/'}}"+type + "",
		                dataType: 'json',
		                success: function (resp) {                
		                    if(resp.type === "success"){
		                        if(resp.data.length > 0){
		                            // refresh table
		                            $("" + table + " > tbody tr").remove();
		                            // Loop through and append rows
		                            let data = resp.data;

		                            if(type == 0){
		                            	data.map( (item, index) => {
			                                return(
			                                    $(""+table+" > tbody").append(
			                                    	"<tr id = 'row_"+ item.id +"'>\
										    			<td>" + item.drug + "</td>\
										    			<td>" + item.dose + "</td>\
										    			<td>" + item.by + "</td>\
										    			<td>" + item.prescribed_on + "</td>\
										    			<td>\
										    				<div class='btn-group'>\
										    					<button type='button' class='btn btn-danger cancel-o-prescription' id = '"+ item.id+"'><i class = 'fa fa-times' ></i> Cancel</button>\
										    				</div>\
										    			</td>\
										    		</tr>"
			                                    )
			                                );
			                            });
		                            }else{
		                            	data.map( (item, index) => {
			                                return(
			                                    $(""+table+" > tbody").append(
			                                    	"<tr id = 'row_"+ item.id +"'>\
										    			<td>" + item.drug + "</td>\
										    			<td>" + item.dose + "</td>\
										    			<td>" + item.by + "</td>\
										    			<td>" + item.prescribed_on + "</td>\
										    			<td>\
										    				<div class='btn-group'>\
										    					<a class='btn btn-primary administer' onclick = 'showModal("+item.id+");' id = '"+ item.id+"'><i class = 'fa fa-plus'></i> Administer</a>\
										    					<button type='button' class='btn btn-success view-logs' data-toggle='modal' href='#modal-view' id = '"+ item.id+"'><i class = 'fa fa-eye'></i> View</button>\
										    					<button type='button' class='btn btn-danger cancel-reg-prescription' id = '"+ item.id+"'><i class = 'fa fa-times' ></i> Cancel</button>\
										    				</div>\
										    			</td>\
										    		</tr>"
			                                    )
			                                );
			                            });
		                            }
		                           

		                            $("" + table + "").css("display","block");
		                            $("" + table + "").show();
		                           
		                        }else{
		                            $("" + table + "").css("display","none");
		                            $("" + table + "").hide();
		                            // alertify.error("No prescriptions found for this patient");
		                        }
		                    }else{
		                        alertify.error(resp.message);
		                    }
		                   
		                },
		                error: function (resp) {
		                	$("" + table + "").hide();
		                	alertify.error(resp.message);
		                }
		            });
		        }

		        $('#savePrescription').click(function(e){
		            e.preventDefault();
		            let pre_type = ($("#type").is(":checked")) ? 1 : 0;

		             $.ajax({
		                type: "POST",
		                url: "{{ url('/api/inpatient/v1/prescriptions') }}",
		                data: JSON.stringify({
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
		                 }),
		                success: function (resp) {
		                    // add table rows
		                     if(resp.type === "success"){
		                        alertify.success(resp.message);
		                        getPrescriptions(pre_type);
		                    }else{
		                    	 alertify.error(resp.message);
		                    }
		                },
		                error: function (resp) {
		                    alertify.error(resp.message);
		                }
		            });
		        });

		        $('.cancel-o-prescription').click(function(){
		        	console.log("cancel clicked once only");
		        	// e.preventDefault();
		        	alert($(this).attr('id'));
		        	$.ajax({
		                type: "POST",
		                url: "{{ url('/api/inpatient/v1/prescriptions/cancel') }}",
		                data: JSON.stringify({ id : $(this).attr('id') }),
		                success: function (resp) {
		                    // update table rows
		                     if(resp.type === "success"){
		                        alertify.success(resp.message);
		                        getPrescriptions(0);
		                    }else{
		                    	 alertify.error(resp.message);
		                    }
		                },
		                error: function (resp) {
		                    alertify.error(resp.message);
		                }
		            });

		        });

		         $('.cancel-reg-prescription').click(function(){
		        	console.log("cancel clicked regular");
		        	// e.preventDefault();
		        	alert($(this).attr('id'));
		        	$.ajax({
		                type: "POST",
		                url: "{{ url('/api/inpatient/v1/prescriptions/cancel') }}",
		                data: JSON.stringify({ id : $(this).attr('id') }),
		                success: function (resp) {
		                    // update table rows
		                     if(resp.type === "success"){
		                        alertify.success(resp.message);
		                        getPrescriptions(0);
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