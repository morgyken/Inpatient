<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Record Patient Vitals</h5>
    </div>
    <div class="panel-body">
        {!! Form::open(['url' => 'inpatient/evaluations/'.$visit->id.'/patient-vitals', 'id' => 'vitals-form', 'class' => 'row']) !!}

            {!! Form::hidden('visit_id', $visit->id) !!}

            {!! Form::hidden('user_id', Auth::user()->id) !!}

            {!! Form::hidden('admission_id', $visit->admission->id) !!}            

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('Date Recorded') !!}
                    {!! Form::date('date_recorded', \Carbon\Carbon::now('Africa/Nairobi')->toDateString(), ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('Time Recorded') !!}
                    {!! Form::time('time_recorded', \Carbon\Carbon::now()->format('H:i A'), ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Waist Circumference:[cm]') !!}
                    {!! Form::number('waist', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Weight:[Kgs]') !!}
                    {!! Form::number('weight', isset($admission->vitals->weight) ?? $admission->vitals->weight, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Hip Circumference:[cm]') !!}
                    {!! Form::number('hip', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Height:[m]') !!}
                    {!! Form::number('height', isset($admission->vitals->height) ?? $admission->vitals->height, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Blood Sugar') !!}
                    {!! Form::number('blood_sugar', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('BP Systolic:[mm/hg]') !!}
                    {!! Form::number('bp_systolic', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Blood Sugar Units') !!}
                    {!! Form::select('blood_sugar_units', ['mmol/L'=>'mmol/L', 'mg/dL'=>'mg/dL'], 'mmol/L', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('BP Diastolic:[mm/hg]') !!}
                    {!! Form::number('bp_diastolic', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Allergies') !!}
                    {!! Form::text('allergies', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Pulse:[Per Min]') !!}
                    {!! Form::number('pulse', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Chronic Illnesses') !!}
                    {!! Form::text('chronic_illnesses', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Respiration:[Per min]') !!}
                    {!! Form::number('respiration', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Temperature:[Celsius]') !!}
                    {!! Form::number('temperature', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Temperature Location]') !!}
                    {!! Form::select('temperature_location', [
                        'Oral' => 'Oral', 'Tympanic Membrane' => 'Tympanic Membrane',
                        'Axillary' => 'Axillary', 'Temporal Artery' => 'Temporal Artery', 'Rectal' => 'Rectal'
                    ], 'Oral', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Oxygen Saturation:[%]') !!}
                    {!! Form::number('oxygen', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::submit('Record Vitals', ['class'=>'btn btn-primary col-md-4']) !!}
                </div>
            </div>

        {!! Form::close() !!}
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
</div>        