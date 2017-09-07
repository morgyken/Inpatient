<div id="prescription" class="tab-pane fade">
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
			        		<input type="text" name="take" id="Take" class="form-control" required />
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
		            Yes <input type="checkbox" name="allow_substitution" id = "allow_substitution" style="width: 100px !important;" value="1" required />
		        </td>
		    </tr>

		    <tr>
		        <th>Regular prescription?</th>
		        <td style="font-size:1.5em;">
		            Yes <input type="checkbox" name="type" id = "type" style="width: 100px !important;" value="1" required />
		        </td>
		    </tr>
		</table>
		<button type="submit" class="btn btn-lg btn-primary " id="savePrescription">
		    <i class="fa fa-save"></i> Save
		</button>
	{!! Form::close() !!}
	<br/>
	<div class="alerts-prescriptions"></div>
	

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3>ONCE ONLY PRESCRIPTIONS, STAT DOSES, PRE-MED Etc.</h3>
		{{-- @if(count($prescriptions) > 0) --}}
		 <table class="table table-hover" id = "single-prescriptions-table" style="display:none !important;">
	    	<thead>
	    		<tr>
	    			<th>Drug</th>
	    			<th>Dosage & Duration</th>
	    			<th>Prescribed By</th>
	    			<th>Prescribed On</th>
	    		</tr>
	    	</thead>
	    	
	    	<tbody>
	    	
	    		{{-- @foreach($prescriptions as $p)
	    		<tr>
	    			<td>{{ $p->drug }}</td>
	    			<td>{{ $p->dose }}</td>
	    			<td>{{ $p->users->full_name }}</td>
	    			<td>{{ \Carbon\Carbon::parse($p->created_at)->format('ds M,Y') }}</td>
	    		</tr>
	    		@endforeach --}}
	    	</tbody>
	    	
	    </table>
    	{{-- @else
    		<div class="alert alert-info" style="padding-top: 10px !important;">
    			 There are no previous once only prescriptions for this patient
    		</div>
    	@endif --}}
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3>REGULAR PRESCRIPTIONS</h3>	
		{{-- @if(count($prescriptions) > 0) --}}
		    <table class="table table-hover" id = "regular-prescriptions-table" style="display:none !important;">
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
		    		{{-- @foreach($prescriptions as $p)
			    		<tr>
			    			<td>{{ $p->drug }}</td>
			    			<td>{{ $p->dose }}</td>
			    			<td>{{ $p->users->full_name }}</td>
			    			<td>{{ \Carbon\Carbon::parse($p->created_at)->format('ds M,Y') }}</td>
			    			<td>
			    				<div class="btn-group">
			    					<button type="button" class="btn btn-primary"><i class = "fa fa-plus"></i> Administer</button>
			    					<button type="button" class="btn btn-success"><i class = "fa fa-pencil"></i></button>
			    					<button type="button" class="btn btn-danger"><i class = "fa fa-trash-o"></i></button>
			    				</div>
			    			</td>
			    		</tr>
		    		@endforeach --}}
		    	</tbody>
		    </table>
		   {{--  @else
	    		<div class="alert alert-info" style="padding-top: 10px !important;">
	    			 There are no previous regular prescriptions for this patient
	    		</div>
	    	@endif --}}
    </div>

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
					<input type = "hidden" name = "prescription_id" />
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
					<button type="button" id = "administer" class="btn btn-primary">Administer</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
								    					<button type='button' class='btn btn-danger cancel-prescription'><i class = 'fa fa-times'></i> Cancel</button>\
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
								    					<button type='button' class='btn btn-primary' data-toggle='modal' href='#modal-id'><i class = 'fa fa-plus'></i> Administer</button>\
								    					<button type='button' class='btn btn-danger cancel-prescription'><i class = 'fa fa-times'></i> Cancel</button>\
								    				</div>\
								    			</td>\
								    		</tr>"
	                                    )
	                                );
	                            });
                            }
                           

                            $("" + table + "").css("display","block");
                           
                        }else{
                            $("" + table + "").css("display","none");
                            showAlert(1, "No prescriptions found for this patient", 0);
                        }
                    }else{
                        showAlert(2, "An error occured while retrieving prescriptions for this patient", 0);
                    }
                   
                },
                error: function () {
                    showAlert(2, "An error occured while retrieving the prescriptions for this patient", 0);
                }
            });
        }

        $('#savePrescription').click(function(e){
            e.preventDefault();
             $.ajax({
                type: "POST",
                url: "{{ url('/api/inpatient/v1/prescriptions') }}",
                data: JSON.stringify({
                     	visit_id : {{ $admission->visit_id }},
                     	admission_id: {{ $admission->id }},
                    	user: {{ Auth::user()->id }},
						drug: parseInt($("#item_0").val()),
						take: parseInt($("#take").val()),
						whereto: parseInt($("#whereto").val()),
						method: parseInt($("#method").val()),
						duration: parseInt($("#duration").val()),
						allow_substitution: $("#allow_substitution").val(),
						time_measure: parseInt($("#time_measure").val()),
                     	type: $("#type").val()
                 }),
                success: function (resp) {
                    // add table rows
                     if(resp.type === "success"){
                        showAlert(1, "There are no previous notes recorded for this patient", 1);
                        showAlert(2, "An error occured while saving the doctor's notes for this patient", 1);
                        showAlert(0, " Note saved", 0);
                        getNotes();
                    }else{
                    	 alertify.error(resp.message)
                         // showAlert(2, "An error occured while saving the doctor's notes for this patient", 0);
                    }
                },
                error: function (resp) {
                    console.log(resp);
                    alertify.error(resp.message)
                    // showAlert(2, "An error occured while saving the doctor's notes for this patient", 0);
                }
            });
        });

         function showAlert(type, text, display){
            var d = (display == 0) ? "block" : "none";
            var t = (type == 0) ? "success" : (type == 1) ? "info" : "danger";
            var i = (type == 0) ? "Success!" : (type == 1) ? "<i class = 'fa fa-exclamation-circle'></i>" : "<i class = 'fa fa-check-warning'></i>";

            $(".alerts-prescriptions").html("");

            $(".alerts-prescriptions").html(
                "<div class='alert alert-"+ t +"' style = 'display:"+ d+";'>\
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>\
                    <strong>"+i+"</strong> "+ text +" \
                </div>"
            );           
        }

</script>