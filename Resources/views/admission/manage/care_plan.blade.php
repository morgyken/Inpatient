<div role="tabpanel" id="plan" class="tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <br>
        <form id="care_plan">

            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $admission->visit_id }}" required>
     
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding: 0 !important;">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date_recorded" id="date_recorded" class="form-control" value = "{{ \Carbon\Carbon::now('Africa/Nairobi')->toDateString() }}" required>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Time</label>
                    <input type="text" name="time_recorded" id="time_recorded" class="form-control" value = "{{ \Carbon\Carbon::now()->format('H:i') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Nursing Diagnosis</label>
                <input type="text" name="diagnosis" id="diagnosis" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Expected Outcome</label>
                <input type="text" name="expected_outcome" id="expected_outcome" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Interventon/Implementation</label>
                <input type="text" name="intervention" id="intervention" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Scientific Rationale/ Reasons</label>
                <input type="text" name="reasons" id="reasons" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Evaluation</label>
                <input type="text" name="evaluation" id="evaluation" class="form-control" required>
            </div>
           
            <button type="button" class="btn btn-medium btn-primary" id = "save-plan"><i class = "fa fa-save"></i> Save</button>
        </form>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
            <h3>Previous Care Plans</h3><hr/>            

            <div class="table-responsive">
                <table class="table table-stripped" id = "care-plan-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Diagnosis</th>
                            <th>Expected Outcome</th>
                            <th>Recorded By</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($nursingCarePlans as $n)
                        <tr id = "{{ $n->id }}">
                            <td>{{ $n->date_recorded }}&nbsp;{{ $n->time_recorded }}</td>
                            <td>{{ $n->diagnosis }}</td>
                            <td>{{ $n->expected_outcome }}</td>
                            <td>{{ $n->user->profile->fullName }}</td>
                            <td>
                                <div class='btn-group'>
                                  {{--   <button type='button' class='btn btn-primary view-plan' id = '{{ $n->id }}'><i class = 'fa fa-pencil' ></i> View</button> --}}
                                    <button type='button' class='btn btn-danger delete-plan' id = '{{ $n->id }}'><i class = 'fa fa-times' ></i> Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach                      
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-view-care-plan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">View Care Plan</h4>
                    </div>
                    <div class="modal-body">
                        <p id = "plan-view"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete-care-plan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Are you sure you want to delete this note?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger yes-delete-plan">Yes</button>
                        <button type="button" class="btn btn-success" id = "no-delete-plan"  data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        
    <script type="text/javascript">

        $(document).ready(function(){
            
            $("#care-plan-table").dataTable();

            $("#time_recorded").timepicker({ 'scrollDefault': 'now' });

            $('#save-plan').click(function(e){
                e.preventDefault();

                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/plans') }}",
                    data: JSON.stringify({
                         visit_id : {{ $admission->visit_id }},
                         admission_id: {{ $admission->id }},
                         diagnosis: $("#diagnosis").val(),
                         expected_outcome: $("#expected_outcome").val(),
                         intervention: $("#intervention").val(),
                         reasons: $("#reasons").val(),
                         evaluation: $("#evaluation").val(),
                         date_recorded: $("#date_recorded").val(),
                         time_recorded: $("#time_recorded").val(),
                         user_id: {{ Auth::user()->id }}
                     }),
                    success: function (resp) {
                        
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            let data = JSON.parse(resp.data);
                            console.log(data);
                            // append new plan to table
                            data.map( (item, index) => {
                                return(
                                    $("#care-plan-table > tbody").append("<tr id = 'plan_row_"+ item.id +"'>\
                                        <td>" + item.date_time + "</td>\
                                        <td>" + item.diagnosis + "</td>\
                                        <td>" + item.expected_outcome + "</td>\
                                        <td>" + item.name + "</td>\
                                        <td><div class='btn-group'>\
                                             <button type='button' class='btn btn-danger delete-plan' id = '"+ item.id + "'><i class = 'fa fa-times' ></i> Delete</button>\
                                         </div></td></tr>")
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

            $('body').on('click','.view-plan', function(e){
                e.preventDefault();
                let id =  $(this).attr('id');
                 
                $("#modal-view-care-plan").modal();
            });

            $('body').on('click','.delete-plan', function(e){
                e.preventDefault();
                let id =  $(this).attr('id');
                $(".yes-delete-plan").attr('id', id); 
                $("#modal-delete-care-plan").modal();
            });

            $('.yes-delete-plan').click(function(e){
                var id = $(this).attr('id');
                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/plans/delete') }}",
                    data: JSON.stringify({ id : id }),
                    success: function (resp) {
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#plan_row_"+id+"").remove();
                            $("#modal-delete-care-plan").modal('toggle');
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
