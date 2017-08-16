<div id="doctor" class="tab-pane fade">

    
    @if(!$doctor_note)

        <div class="container demo">

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                Collapsible Group Item #1
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                              
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                Collapsible Group Item #2
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                           
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                Collapsible Group Item #3
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            
                        </div>
                    </div>
                </div>

            </div><!-- panel-group -->
            
            
        </div><!-- container -->

        <h2><small class="alert alert-warning">No Doctor Note</small>   </h3>

        <div>
            <textarea name="presenting_complaints" id="" class="form-control" rows="3"></textarea>
        </div>
        <div>
            <textarea name="past_medical_history" id="" class="form-control" rows="3"></textarea>
        </div>
        <div>
            <textarea name="examination" id="" class="form-control" rows="3"></textarea>
        </div>

        <div>
            <textarea name="presenting_complaints" id="" class="form-control" rows="3"></textarea>
        </div>

        <div>
            <textarea name="diagnosis" id="" class="form-control" rows="3"></textarea>
        </div>
        <div>
            <textarea name="investigations" id="" class="form-control" rows="3"></textarea>
        </div>
        <div>
            <textarea name="treatment_plan" id="" class="form-control" rows="3"></textarea>
        </div>
    @else
        <div>
        <textarea name="presenting_complaints" id="" class="form-control"
                  rows="3">{{ $doctor_note->complaints }}</textarea>
        </div>

        <div>
        <textarea name="past_medical_history" id="" class="form-control"
                  rows="3">{{ $doctor_note->past_medical_history }}</textarea>
        </div>

        <div>
        <textarea name="examination" id="" class="form-control"
                  rows="3">{{ $doctor_note->examination }}</textarea>
        </div>

        <div>
        <textarea name="presenting_complaints" id="" class="form-control"
                  rows="3">{{ $doctor_note->complaints }}</textarea>
        </div>

        <div>
        <textarea name="diagnosis" id="" class="form-control"
                  rows="3">{{ $doctor_note->diagnosis }}</textarea>
        </div>

        <div>
        <textarea name="investigations" id="" class="form-control"
                  rows="3">{{ $doctor_note->investigations }}</textarea>
        </div>

        <div>
        <textarea name="treatment_plan" id="" class="form-control"
                  rows="3">{{ $doctor_note->treatment_plan }}</textarea>
        </div>
    @endif
</div>