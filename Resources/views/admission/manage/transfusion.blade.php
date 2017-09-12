<div role="tabpanel" id="blood" class="tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <br>
        <form id="transfusion" action="{{ url('/inpatient/manage/notes') }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $admission->visit_id }}" required>
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0 !important;">

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding: 0 !important;">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding: 0 !important;">
                        <label for="" class="control-label">Date recorded:</label>
                        <input type="date" class="form-control" name="blood_date_recorded" id ="blood_date_recorded" value = "{{ \Carbon\Carbon::now('Africa/Nairobi')->toDateString() }}" required>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding: 0 !important;">
                        <label for="" class="control-label">Time recorded:</label>
                        <input type="text" class="form-control" name="blood_time_recorded" id ="blood_time_recorded" value = "{{ \Carbon\Carbon::now()->format('H:i') }}" required>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                         <div class="form-group">
                            <label>Temperature (<sup>o</sup>C)</label>
                            <input type="number" name="blood_temperature" id="blood_temperature" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding: 0 !important; padding-left: 5px !important;">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding: 0 !important;">
                        <label for="" class="control-label">BP Systolic:[mm/hg]</label>
                        <input type="number" class="form-control" name="blood_bp_systolic" id = "blood_bp_systolic" required>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding: 0 !important;">
                        <label for="" class="control-label">BP Diastolic:[mm/hg]</label>
                        <input type="number" class="form-control" name="blood_bp_diastolic" id = "blood_bp_diastolic" required>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important; padding-left: 1px !important;">
                        <label>Respiration Rate</label>
                        <input type="number" name="blood_respiration" id="blood_respiration" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="padding: 0 !important;">
                <br/>
                <label>Remarks:</label>
                 <textarea name="blood_remarks" id="blood_remarks" class="form-control" rows="3" cols="10" required></textarea>
             </div> 
           
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                <br/>
                <button type="button" class="btn btn-lg btn-primary" id = "save-transfusion"><i class = "fa fa-save"></i> Save</button>
            </div>
           
        </form>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
            <h3>Previous Blood Transfusion Data</h3>

            <div class="alerts"></div>

            <div class="table-responsive">
                <table class="table table-stripped" id = "transfusion-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Temp.</th>
                            <th>BP</th>
                            <th>Resp. Rate</th>
                            <th>Remarks</th>
                            <th>Recorded By</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($transfusions as $t)
                        <tr id = "transfusion_row_{{ $t->id }}">
                            <td>{{ $t->date_recorded }} {{ $t->time_recorded }}</td>
                            <td>{{ $t->temperature }}</td>
                            <td>{{ $t->users->profile->fullName }}</td>
                            <td>
                                <div class='btn-group'>
                                   {{--  <button class='btn btn-primary view-transfusion' id = '{{ $t->id }}'><i class = 'fa fa-eye'></i> View</button>
                                    <button type='button' class='btn btn-success edit-transfusion' id = '{{ $t->id }}'><i class = 'fa fa-pencil'></i> Edit</button> --}}
                                    <button type='button' class='btn btn-danger delete-transfusion' id = '{{ $t->id }}'><i class = 'fa fa-times' ></i> Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                      
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-view-doctor-transfusion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Recorded By <span id = "doctor-info"></span></h4>
                    </div>
                    <div class="modal-body">
                        <form>
                          
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id = "edit-blood-view">Edit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Are you sure you want to delete this note?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger yes">Yes</button>
                        <button type="button" class="btn btn-success" id = "no"  data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        
    <script type="text/javascript">

        $(document).ready(function(){
            $('#save-transfusion').click(function(e){
                e.preventDefault();

                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/transfusions') }}",
                    data: JSON.stringify({
                         visit_id : {{ $admission->visit_id }},
                         admission_id: {{ $admission->id }},
                         temperature: parseInt($("#blood_temperature").val()),
                         bp_diastolic: parseInt($("#blood_bp_diastolic").val()),
                         bp_systolic: parseInt($("#blood_bp_systolic").val()),
                         respiration:   parseInt($("#blood_respiration").val()),
                         remarks: $("#blood_remarks").val(),
                         date_recorded: $("#blood_date_recorded").val(),
                         time_recorded: $("#blood_time_recorded").val(),
                         user_id: {{ Auth::user()->id }}
                     }),
                    success: function (resp) {
                        
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            let data = JSON.parse(resp.data);
                            console.log(data);
                            // append new plan to table
                            data.map( (item) => {
                                return(
                                    $("#transfusion-table > tbody").append("<tr id = 'transfusion_row_"+ item.id +"'>\
                                        <td>" + item.date_time + "</td>\
                                        <td>" + item.temperature + "</td>\
                                        <td>" + item.bp + "</td>\
                                        <td>" + item.respiration + "</td>\
                                        <td>" + item.remarks +"</td>\
                                        <td>\
                                            <div class='btn-group'>\
                                                <button type='button' class='btn btn-danger delete-transfusion' id = '"+ item.id +"'><i class = 'fa fa-times' ></i> Delete</button>\
                                            </div>\
                                        </td></tr>")
                                );
                            });
                        }else{
                             alertify.error(resp.message);
                        }
                    },
                    error: function (resp) {
                        console.log(resp);
                        alertify.error(resp.message);
                    }
                });
            });
        });    
    </script>
  
</div>
