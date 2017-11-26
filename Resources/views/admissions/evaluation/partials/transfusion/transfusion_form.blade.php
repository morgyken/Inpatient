<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Blood Tranfusion</h5>
    </div>

    <div class="panel-body">
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
                        <input type="text" class="form-control" name="blood_time_recorded" id ="blood_time_recorded" value = "{{ \Carbon\Carbon::now()->format('H:i a') }}" required>
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
                <label>Remarks:</label>
                 <textarea name="blood_remarks" id="blood_remarks" class="form-control" rows="3" cols="10" required></textarea>
             </div> 
           
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                <br/>
                <button type="button" class="btn btn-sm btn-primary" id = "save-transfusion">Record Details</button>
            </div>
           
        </form>
    </div>
    <script type="text/javascript">

        $(document).ready(function(){

            $("#transfusion-table").dataTable();

            // $("#blood_time_recorded").timepicker({ 'scrollDefault': 'now' });
            
            $('#save-transfusion').click(function(e){
                e.preventDefault();

                var errors = validateValues();
                var isValid = (errors.length > 0) ? false : true;

                if(isValid){
                   supmitForm();
                }else{
                    errors.forEach(item => { alertify.error("<i class = 'fa fa-exclamation-circle'></i> " + item); });
                }
            });

            function validateValues(){
                var errors = [];
                if($("#blood_temperature").val() > 40) {
                    errors.push("The Temperature can't be above 40 Degrees Celcius!");
                }else if($("#blood_temperature").val() <= 0) {
                    errors.push("The Temperature can't be below 0 Degrees Celcius!");
                }else if($("#blood_bp_systolic").val() <= 0 || $("#blood_bp_diastolic").val() <= 0) {
                    errors.push("You have Invalid Blood Pressure Values!");
                }else if($("#blood_respiration").val() <= 0) {
                    errors.push("You have an Invalid Respiration rate value!");
                }else if($("#blood_time_recorded").val().trim().length <= 0){
                     errors.push("You must specify the time recorded!");
                }else if($("#blood_date_recorded").val().trim().length <= 0){
                     errors.push("You must specify the date recorded!");
                }
                return errors;
            }

            function supmitForm(){

                let data = JSON.stringify({
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
                 });

                $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/transfusions') }}",
                    data: data,
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
                                        <td>" + item.temperature + "<sup>o</sup>C</td>\
                                        <td>" + item.bp + "</td>\
                                        <td>" + item.respiration + "</td>\
                                        <td>" + (item.remarks.length > 0) ? item.remarks : 'None' +"</td>\
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
            }

            $('body').on('click','.delete-transfusion', function(e){
                e.preventDefault();
                let id =  $(this).attr('id');
                $(".yes-delete-transfusion").attr('id', id); 
                $("#modal-delete-transfusion").modal();
            });

            $('.yes-delete-transfusion').click(function(e){
                var id = $(this).attr('id');
                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/transfusions/delete') }}",
                    data: JSON.stringify({ id : id }),
                    success: function (resp) {
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#transfusion_row_"+id+"").remove();
                            $("#modal-delete-transfusion").modal('toggle');
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
