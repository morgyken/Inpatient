<div role="tabpanel" id="vitals" class="tab-pane fade col-lg-12">

    <!--If not recorded add to db else display and enable edit -->
       
        <div class="col-xs-12 col-sm-12 col-md-12">
             <h2>Record Patient's Vitals</h2>
            <form id = "vitals-form">

                {{ csrf_field() }}

                <input type="hidden" name="visit_id" id = "visit_id" value="{{ $admission->visit_id }}" required>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding:0 !important;">
                    <br>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding: 0 !important;">
                         <label for="" class="control-label">Date recorded:</label>
                            <input type="date" class="form-control" name="date_recorded" id ="date_recorded" value = "{{ \Carbon\Carbon::now('Africa/Nairobi')->toDateString() }}" required>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <label for="" class="control-label">Time recorded:</label>
                            <input type="text" class="form-control" name="time_recorded" id ="time_recorded" value = "{{ \Carbon\Carbon::now()->format('H:i A') }}" required>
                        </div>
                    </div>                    

                    <label for="" class="control-label">Weight:(Kgs)</label>
                    <input type="number" class="form-control" name="weight" id ="weight" value = "{{ (isset($admission->vitals->weight)) ? $admission->vitals->weight : "" }}" required>

                    <label for="" class="control-label">Height:(Metres)</label>
                    <input type="text" class="form-control" name="height" id ="height" value = "{{ (isset($admission->vitals->height)) ? $admission->vitals->height : "" }}" required>

                    <label for="" class="control-label">BP Systolic:[mm/hg]</label>
                    <input type="number" class="form-control" name="bp_systolic" id = "bp_systolic">

                    <label for="" class="control-label">BP Diastolic:[mm/hg]</label>
                    <input type="number" class="form-control" name="bp_diastolic" id = "bp_diastolic">

                    <label for="" class="control-label">Pulse:[Per Min]</label>
                    <input type="number" class="form-control" name="pulse" id="pulse">

                    <label for="" class="control-label">Respiration:[Per min]</label>
                    <input type="number" class="form-control" name="respiration" id = "respiration">

                    <label for="" class="control-label">Temperature:[Celsius]</label>
                    <input type="number" class="form-control" name="temperature" id = "temperature">

                    <label for="" class="control-label">Temperature Location:</label>
                    <select class="form-control" name="temperature_location" id = "temperature_location">
                        <option value="Oral">Oral</option>
                        <option value="Tympanic Membrane">Tympanic Membrane</option>
                        <option value="Axillary">Axillary</option>
                        <option value="Temporal Artery">Temporal Artery</option>
                        <option value="Rectal">Rectal</option>
                    </select>

                    <label for="" class="control-label">Oxygen Saturation:[%]</label>
                    <input type="number" class="form-control" name="oxgyen" id = "oxygen">                   
                </div>


                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding:0 0 0 5px !important;">
                    <br>
                    <label for="" class="control-label">Waist Circumference:[cm]</label>
                    <input type="number" class="form-control" name="waist" id = "waist">

                    <label for="" class="control-label">Hip Circumference:[cm]</label>
                    <input type="number" class="form-control" name="hip" id = "hip">
                   {{--  <label for="" class="control-label">Waist to Hip Ratio</label>
                    <input type="number" class="form-control" disabled name="waist_hip_ratio">

                    <label for="" class="control-label">BMI:[%]</label>
                    <input type="number" class="form-control bmi" disabled name="bmi" id = "bmi">

                    <label for="" class="control-label">BMI Status:</label>
                    <input type="text" class="form-control" disabled name="bmi_status" id = "bmi_status"> --}}
                    
                    <label for="" class="control-label">Blood Sugar:</label>
                    <input type="number" class="form-control" name="blood_sugar" id = "blood_sugar">

                    <label for="" class="control-label">Blood Sugar Units:</label>
                    <select name="blood_sugar_units" id="blood_sugar_units" class="form-control" required="required">
                        <option value="mmol/L">mmol/L</option>
                        <option value="mg/dL">mg/dL</option>
                    </select>

                    <label for="" class="control-label">Allergies:</label>
                    <input type="text" class="form-control" name="allergies" id = "allergies" value="None">

                    <label for="" class="control-label">Chronic Illnesses:</label>
                    <input type="text" class="form-control" name="chronic_illnesses" id = "chronic_illnesses" value="None">

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12" style="padding: 0 !important;">
                    <br>
                    <button type="button" class="btn  btn-primary" id = "record-vitals">Record</button>
                </div>
            </form>
        </div>


       
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <h3>Previous Vitals</h3>
            @if(count($vitals) <= 0)
                <div class="alert alert-info">
                    There are no vitals recorded for this patient
                </div>             
            @endif

            <div class="table-responsive">
                <table class="table table-stripped table-hover" id = "vitals-table">
                    <thead>
                        <tr>
                            <th>DateTime</th>
                            <th>Status</th>
                            <th>Temp</th>
                            <th>BP</th>
                            <th>Resp</th>
                            <th>Pulse</th>
                            <th>O<sub>2</sub></th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vitals as $v)
                            <tr id = "vitals_row_{{ $v['id'] }}">
                                <td>{{ $v['date_time_recorded'] }}</td>
                                <td>{{ $v['bmi_status'] }}</td>
                                <td>{{ $v['temperature'] }} <sup>o</sup>C</td>
                                <td>{{ $v['bp'] }}</td>
                                <td>{{ $v['respiration'] }}</td>
                                <td>{{ $v['pulse'] }}</td>
                                <td>{{ $v['oxygen'] }}</td>
                                <td>
                                    <div class="btn-group">
                                       {{--  <button type='button' class='btn btn-primary view-vitals'><i class = 'fa fa-eye'></i> View</button> --}}
                                        <button type="button" class="btn btn-danger delete-vitals" id = "{{ $v['id']}}"><i class = "fa fa-trash-o"></i> Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    <div class="modal fade" id="modal-delete-vitals">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3>Are you sure you want to cancel this vitals record?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger yes-delete-vitals">Yes</button>
                    <button type="button" class="btn btn-success" id = "no-delete-vitals"  data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
    
    $(document).ready(function(){

        $("#vitals-table").dataTable();

        $("#time_recorded").timepicker({ 'scrollDefault': 'now' });
                
        $('#record-vitals').click(function(e){
            e.preventDefault();
            var errors = validateValues();
            var isValid = (errors.length > 0) ? false : true;

            if(isValid){
               submitForm();
            }else{
                errors.forEach(item => {
                    alertify.error("<i class = 'fa fa-exclamation-circle'></i> " + item);
                });
            }
        });

        function validateValues(){
            var errors = [];

            if($("#temperature").val() > 40) {
                errors.push("The Temperature can't be above 40 Degrees Celcius!");
            }else if($("#temperature").val() <= 0) {
                errors.push("The Temperature can't be below 0 Degrees Celcius!");
            }else if($("#bp_systolic").val() <= 0 || $("#bp_diastolic").val() <= 0) {
                errors.push("You have Invalid Blood Pressure Values!");
            }else if($("#pulse").val() <= 0) {
                errors.push("You have Invalid pulse Values!");
            }else if($("#respiration").val() <= 0) {
                errors.push("You have an Invalid Respiration rate value!");
            }else if($("#oxygen").val() <= 0) {
                 errors.push("You have an Invalid Oxygen Saturation Value!");
            }else if($("#weight").val() < 0) {
                errors.push("You have an Invalid Weight Value!");
            }else if($("#height").val() < 0) {
                errors.push("You have an Invalid Weight Value!");
            }

            return errors;
        }

        function submitForm(){
            let data = JSON.stringify({
                            visit_id : {{ $admission->visit_id }},
                            admission_id: {{ $admission->id }},
                            user_id: {{ Auth::user()->id }},
                            height : parseFloat($("#height").val()),
                            weight : parseFloat($("#weight").val()),
                            bp_systolic : parseInt($("#bp_systolic").val()),
                            bp_diastolic : parseInt($("#bp_diastolic").val()),
                            pulse : parseInt($("#pulse").val()),
                            respiration : parseInt($("#respiration").val()),
                            temperature : parseFloat($("#temperature").val()),
                            temperature_location : $("#temperature_location").val(),
                            oxygen : parseFloat($("#oxygen").val()),
                            waist : parseFloat($("#waist").val()),
                            hip : parseFloat($("#hip").val()),
                            blood_sugar : parseFloat($("#blood_sugar").val()),
                            blood_sugar_units : $("#blood_sugar_units").val(),
                            allergies : $("#allergies").val(),
                            chronic_illnesses : $("#chronic_illnesses").val(),
                            date_recorded : $("#date_recorded").val(),
                            time_recorded: $("#time_recorded").val()
                    });

            $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/vitals') }}",
                    data: data,
                    success: function (resp) {
                        // add table rows
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            // append To Table
                            let data = JSON.parse(resp.data);
                            data.map( (item, index) => {
                                return(
                                    $("#vitals-table > tbody").append("<tr id = 'vitals_row_"+item.id+"'>\
                                        <td>"+ item.date_time_recorded +"</td>\
                                        <td>"+ item.weight +" Kgs</td>\
                                        <td>"+ item.height +" m</td>\
                                        <td>"+ item.bmi +"</td>\
                                        <td>"+ item.bmi_status +"</td>\
                                        <td>"+ item.temperature +" <sup>o</sup>C</td>\
                                        <td>"+ item.bp +"</td>\
                                        <td>"+ item.respiration +"</td>\
                                        <td>"+ item.pulse +"</td>\
                                        <td>"+ item.oxygen +"</td>\
                                        <td><button type='button' class='btn btn-danger delete-vitals' id = '"+ item.id +"'><i class = 'fa fa-trash-o'></i> Delete</button></td>\
                                    </tr>")
                                );
                            });
                        }else{
                             alertify.error(resp.message);
                        }
                    },
                    error: function (resp) {
                        alertify.error(resp.message);
                    }
                });
        }

        $('body').on('click', '.delete-vitals', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $(".yes-delete-vitals").attr('id', id); 
                $("#modal-delete-vitals").modal();
            });


            $('.yes-delete-vitals').click(function(e){
                var id = $(this).attr('id');
                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/vitals/delete') }}",
                    data: JSON.stringify({ id : id }),
                    success: function (resp) {
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#modal-delete-vitals").modal('toggle');
                            $("#vitals_row_"+id+"").remove();
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
