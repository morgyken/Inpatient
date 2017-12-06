<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Blood Tranfusion</h5>
    </div>

    <div class="panel-body">
        <div class="row">
            {!! Form::open(['url' => "inpatient/evaluations/$visit->id/blood-transfusion"]) !!}

                {!! Form::hidden('visit_id', $visit->id) !!}

                {!! Form::hidden('user_id', Auth::user()->id) !!}

                {!! Form::hidden('admission_id', $visit->admission->id) !!}            

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('BP Systolic:[mm/hg]') !!}
                        {!! Form::number('bp_systolic', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('BP Diastolic:[mm/hg]') !!}
                        {!! Form::number('bp_diastolic', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Temperature:[deg] ') !!}
                        {!! Form::number('temperature', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Respiration Rate') !!}
                        {!! Form::number('respiration', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('Remarks') !!}
                        {!! Form::textarea('remarks', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::submit('Save', ['class'=>'btn btn-primary col-md-4']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
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
