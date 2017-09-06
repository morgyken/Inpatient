<div id="doctor" class="tab-pane fade in active col-md-12">

    <div class="container demo col-md-12">
        <br>
        <form id="doctor_notes" action="{{ url('/inpatient/manage/notes') }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" value="{{ $admission->visit_id }}" required>

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

            <button type="button" class="btn btn-lg btn-primary"><i class = "fa fa-save"></i> Save</button>
        </form>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
            <h3>Previous Notes</h3>
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Note</th>
                        <th>Recorded By</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div><!-- container -->
   <script type="text/javascript">
        $(function () {
        CKEDITOR.replaceAll();
    });
   </script>
</div>