<div role="tabpanel" id="discharge" class="tab-pane fade col-lg-12">
    <br/>
    @if($admission->Discharged == false)
      <form role="form">  

         <div class="form-group">
            <label class="control-label col-md-4" style="padding: 0 !important;">Discharge Type</label>
            <div class="col-md-8">
                <select name="type" id="discharge_type" value = "discharge" class="form-control">
                    <option selected value="discharge">Discharge Summary</option>
                    <option value="case">Case Discharge</option>
                </select>
            </div>
        </div>

        <div class="case-type" style="display:none !important;">
            <div class="case form-group req"><br/>
                <label class="control-label col-md-4" style="padding: 0 !important;">Date Of Death</label>
                <div class="col-md-8" style="padding-top:5px !important;">
                    <input type="date" name="dateofdeath" id = "dateofdeath" value = "{{ \Carbon\Carbon::now('Africa/Nairobi')->toDateString() }}" class="form-control" />
                </div>  
            </div>
        

            <div class="case form-group req"><br/>
                <label class="control-label col-md-4" style="padding: 0 !important;">Time Of Death</label>
                <div class="col-md-8" style="padding-top:5px !important;">
                    <input type="text" name="timeofdeath" id = "timeofdeath" value = "{{ \Carbon\Carbon::now()->format('H:i a') }}" class="form-control" />
                </div>
            </div>

            <div class=" case form-group"><br/>
                <label class="control-label col-md-4" style="padding: 0 !important;">Case Note</label>
                <div class="col-md-8" style="padding-top:5px !important;">
                    <textarea  name="caseNote" class="form-control summernote" required></textarea>
                </div>
            </div>
        
        </div>

        <div class="summary-type" style="display:none !important;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                <div class="row col-md-12">
                     <div class="form-group col-md-6" style="padding: 0 !important;">
                        <label>Principal Diagnosis</label>
                        <textarea name="principal_diagnosis" id="principal_diagnosis" class="form-control summernote" rows="3" cols = "10" required></textarea>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Other Diagnosis</label>
                        <textarea name="other_diagnosis" id="other_diagnosis" class="form-control summernote" rows="3" cols = "10" required></textarea>
                      </div>
                </div>

                <div class="row col-md-12">
                    <div class="form-group col-md-6" style="padding: 0 !important;">
                        <label>Complaints at Admission</label>
                        <textarea name="complaints" id="complaints" class="form-control summernote" rows="3" cols = "10" required></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Discharge Conditions</label>
                        <textarea name="discharge_conditions" id="discharge_conditions" class="form-control summernote" rows="3" cols = "10" required></textarea>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                <div class="form-group" style="padding: 0 !important;">
                    <label>Investigations and Hospital Courses</label>
                    <textarea name="investigations_courses" id="investigations_courses" class="form-control summernote" rows="3" cols = "10" required></textarea>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                <h4>PRESCRIBE MEDICATION</h4>
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
                              <input type="text" name="take" id="take" class="form-control" required />
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
                        <th>Substitution Allowed? (Check if yes) </th>
                        <td>
                            <input type="checkbox" name="allow_substitution" class = "checkbox" id = "allow_substitution" style="width: 20px !important; height: 20px !important;" required />
                        </td>
                    </tr>

                    <tr>
                        <th>Regular prescription? (Check if yes) </th>
                        <td>
                            <input type="checkbox" name="type" class = "checkbox" id = "type" style="width: 20px !important; height: 20px !important;" required />
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <button type="submit" class="btn btn-info " id="savePrescriptionAtDischarge">
                                <i class="fa fa-save"></i> Prescribe
                            </button>
                        </td>
                    </tr>
                </table>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important';">
                    <table class="table table-stripped table-hover" id = "single-prescriptions-table">
                        <thead>
                            <tr>
                                <th>Drug</th>
                                <th>Dosage & Duration</th>
                                <th>Prescribed By</th>
                                <th>Prescribed On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discharge_prescriptions as $p)
                                <tr id = "discharge_row_{{ $p->id }}">
                                    <td>{{ $p->drugs->name }}</td>
                                    <td>{{ $p->dose }}</td>
                                    <td>{{ $p->users->profile->fullName }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->updated_at)->format('H:i A d/m/Y ')}}</td>
                                    <td>
                                        <div class='btn-group'>
                                            <button type='button' class='btn btn-danger cancel-discharge-prescription' id = '{{ $p->id }}'><i class = 'fa fa-times' ></i> Cancel</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="modal-stop-prescription">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h3>Are you sure you want to cancel this prescription?</h3>
                                <label>If yes, you must provide a reason below</label>
                                <textarea name="stop_reasons" id="stop_reasons" class="form-control" rows="3" cols = "10" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger yes-cancel-discharge-prescription">Yes</button>
                                <button type="button" class="btn btn-success" id = "no-cancel-discharge-prescription"  data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      	
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <br/><br/>
            <div class="pull-right">
                <button type="submit" class="btn btn-lg btn-primary" id = "request_discharge"><i class="fa fa-save"></i> Request Discharge</button>&nbsp;<button type="button" class="btn btn-default" id = "print_summary" style="display: none !important;"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
      
      </form>
      <script>
            var INSURANCE = false;
            var STOCK_URL = "{{route('api.inventory.getstock')}}";
            var PRODUCTS_URL = "{{route('api.inventory.get.products')}}";
            var VISIT_ID = "{{ $admission->visit_id }}";
            var ADMISSION_ID = "{{ $admission->id }}";
            var USER_ID = "{{ Auth::user()->id }}";
            var PRESCRIPTIONS_URL = "{{ url('/api/inpatient/v1/prescriptions') }}";
            var PRESCRIPTIONS_DELETE_URL = "{{ url('/api/inpatient/v1/prescriptions/delete') }}";
        </script>

        <script src="{!! m_asset('evaluation:js/prescription.js') !!}"></script>

        <script type="text/javascript">
            $(document).ready(function(){
             
                $("#time").timepicker({ 'scrollDefault': 'now' });

                var check_type = function () {

                    var v = $("#discharge_type").val();
                    if(v == 'case'){
                        $(".case-type").css("display","block");
                        $(".summary-type").css("display","none");
                    }else{
                        $(".case-type").css("display","none");
                        $(".summary-type").css("display","block");
                    }
                };

                check_type();

                $('.summernote').summernote();

                $("#discharge_type").change(function(){
                    check_type();
                });

                 $('#save-plan').click(function(e){
                    e.preventDefault();
                    let data = JSON.stringify({
                        visit_id : {{ $admission->visit_id }},
                        admission_id: {{ $admission->id }},
                        user_id: {{ Auth::user()->id }},


                    });

                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/discharge') }}",
                    data: data,
                    success: function (resp) {
                        
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            let data = JSON.parse(resp.data);
                            // append new prescriptions if any to table
                            data.map( (item, index) => {
                                return(
                                   
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
    @else
        <div class="alert alert-info">
            <strong><i class="fa fa-exclamation-circle"></strong> This patient has already been discharged
        </div>

    @endif
</div>