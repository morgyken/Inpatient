<div id="doctor" class="tab-pane fade in active col-md-12">

    <div class="container demo col-md-12">
        <br>
        <form id="doctor_notes" action="{{ url('/inpatient/manage/notes') }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $admission->visit_id }}" required>

            <div class="form-group">
                 <label>Write your notes here:</label>
                <textarea name="notes" id="notes" class="form-control" rows="10" placeholder="Doctor's Notes..." required autofocus></textarea>
            </div>
           
           {{--  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="more-less fa fa-caret-down"></i>
                                Notes
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse " role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <textarea name="presenting_complaints" id="presenting_complaints" class="form-control" rows="3" placeholder="Patient Complaints">@if($doctor_note != null) {{ $doctor_note->complaints }} @endif</textarea>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="more-less fa fa-caret-down"></i>
                                Past Medical History
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <textarea name="past_medical_history" id="past_medical_history" class="form-control" rows="3" placeholder="Past Medical History">@if($doctor_note != null) {{ $doctor_note->past_medical_history }} @endif</textarea>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="more-less fa fa-caret-down"></i>
                                Examination
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <textarea name="examination" id="examination" class="form-control" rows="3" placeholder="Examination">@if($doctor_note != null) {{ $doctor_note->examination }} @endif</textarea>
                        </div>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <i class="more-less fa fa-caret-down"></i>
                                Diagnosis
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" placeholder="Diagnosis">@if($doctor_note != null) {{ $doctor_note->diagnosis }} @endif</textarea>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFive">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <i class="more-less fa fa-caret-down"></i>
                                Investigations
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                        <div class="panel-body">
                            <textarea name="investigations" id="investigations" class="form-control" rows="3" placeholder="Investigations">@if($doctor_note != null) {{ $doctor_note->investigations }} @endif</textarea>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingSix">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                <i class="more-less fa fa-caret-down"></i>
                                Treatment Plan
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                        <div class="panel-body">
                           <textarea name="treatment_plan" id="treatment_plan" class="form-control" rows="3" placeholder="Treatment Plan">@if($doctor_note != null) {{ $doctor_note->treatment_plan }} @endif</textarea>
                        </div>
                    </div>
                </div> --}}
            {{-- </div>--}}

            <button type="button" class="btn btn-lg btn-primary" id = "save-note"><i class = "fa fa-save"></i> Save</button>
        </form>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
            <h3>Previous Notes</h3>

            <div class="alerts"></div>

            <div class="table-responsive">
                <table class="table table-stripped" id = "doctors-table" style="width:100% !important; display: none !important;">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Note</th>
                            <th>Recorded By</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
            </div>
        </div>
        
    </div><!-- container -->

    <script type="text/javascript">
        $(function () {
            $("table").dataTable();
        })
        getNotes();

        function getNotes(){
            $.ajax({
                type: "GET",
                url: "{{ url('/api/inpatient/v1/notes/admission/'.$admission->id.'/type/1') }}",
                dataType: 'json',
                success: function (resp) {                
                    if(resp.type === "success"){
                        if(resp.data.length > 0){
                            // refresh table
                            $("#doctors-table > tbody tr").remove();
                            // Loop through and append rows
                            let data = resp.data;
                            data.map( (item, index) => {
                                return(
                                    $("#doctors-table > tbody").append(
                                        "<tr id = 'row_"+ item.id +"'>\
                                            <td>" + item.written_on + "</td>\
                                            <td>" + item.notes + "</td>\
                                            <td>" + item.name + "</td>\
                                            <td><button type='button' class='btn btn-danger delete' id = '"+ item.id +"'><i class = 'fa fa-trash-o'></i> Delete</button></td>\
                                        </tr>"
                                    )
                                );
                            });

                            $("#doctors-table").css("display","block");
                           
                        }else{
                            $("#doctors-table").css("display","none");
                            showAlert(1, "No doctor's notes found for this patient", 0);
                        }
                    }else{
                        showAlert(2, "An error occured while retrieving the doctor's notes for this patient", 0);
                    }
                   
                },
                error: function () {
                    showAlert(2, "An error occured while retrieving the doctor's notes for this patient", 0);
                }
            });
        }

        $('#save-note').click(function(e){
            e.preventDefault();
             $.ajax({
                type: "POST",
                url: "{{ url('/api/inpatient/v1/notes') }}",
                data: JSON.stringify({
                     visit_id : {{ $admission->visit_id }},
                     admission_id: {{ $admission->id }},
                     notes: $("#notes").val(),
                     type: 1,
                     user: {{ Auth::user()->id }}
                 }),
                success: function (resp) {
                    // add table rows
                     if(resp.type === "success"){
                        showAlert(1, "There are no previous notes recorded for this patient", 1);
                        showAlert(2, "An error occured while saving the doctor's notes for this patient", 1);
                        showAlert(0, " Note saved", 0);
                        getNotes();
                    }else{
                         showAlert(2, "An error occured while saving the doctor's notes for this patient", 0);
                    }
                },
                error: function (resp) {
                    console.log(resp);
                    showAlert(2, "An error occured while saving the doctor's notes for this patient", 0);
                }
            });
        });

        $('.delete').click(function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            $(this).html("Deleting ....");
            console.log("deleting");

             $.ajax({
                type: "POST",
                url: "{{ url('/api/inpatient/v1/notes/delete') }}",
                data: JSON.stringify({
                     id : id
                 }),
                success: function (resp) {
                    // add table rows
                     if(resp.type === "success"){
                        $("tr#row_"+id+"").remove();
                        showAlert(0, " Note deleted", 0);
                        $(this).html("<i class = 'fa fa-trash-o'></i> Delete");
                        // getNotes();
                    }else{
                        showAlert(2, "An error occured while deleting the doctor's notes for this patient", 0);
                    }
                },
                error: function (resp) {
                    console.log(resp);
                    $(this).html("<i class = 'fa fa-trash-o'></i> Delete");
                    showAlert(2, "An error occured while deleting the doctor's notes for this patient", 0);
                }
            });
        });

        function showAlert(type, text, display){
            var d = (display == 0) ? "block" : "none";
            var t = (type == 0) ? "success" : (type == 1) ? "info" : "danger";
            var i = (type == 0) ? "Success!" : (type == 1) ? "<i class = 'fa fa-exclamation-circle'></i>" : "<i class = 'fa fa-check-warning'></i>";

            $(".alerts").html("");

            $(".alerts").html(
                "<div class='alert alert-"+ t +"' style = 'display:"+ d+";'>\
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>\
                    <strong>"+i+"</strong> "+ text +" \
                </div>"
            );           
        }
    </script>
  
</div>

