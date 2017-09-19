<div role="tabpanel" id="discharge" class="tab-pane fade col-lg-12">
    <br/>
    @if($admission->Discharged == false)

        @if($admission->has_discharge_request == true)
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
                        <textarea name="caseNote" id = "caseNote" class="form-control summernote" required></textarea>
                    </div>
                </div>
            
            </div>

            <div class="summary-type" style="display:none !important;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                     <div class="form-group">
                        <br/>
                        <label class="control-label col-xs-12 col-sm-12 col-md-4" style="padding: 0 !important;">To Come Again</label>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                           <input type="date" name="to_come_again" id = "to_come_again" class="form-control" value = "{{ \Carbon\Carbon::tomorrow('Africa/Nairobi')->toDateString() }}">
                        </div>
                    </div>
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
                            <textarea name="discharge_condition" id="discharge_condition" class="form-control summernote" rows="3" cols = "10" required></textarea>
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
                            <td><select name="drug" id="item_1" class="form-control select2-single" style="width: 100%" required></select></td>
                        </tr>
                        <tr>
                            <th>Dose</th>
                            <td>
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 !important;">
                                  <input type="text" name="take" id="pre_take" class="form-control" required />
                                </div>
                                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 !important;">
                                    {!! Form::select('whereto',mconfig('evaluation.options.prescription_whereto'),null,['class'=>'form-control', 'id' => 'pre_whereto'])!!}
                                  </div>
                                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 !important;">
                                    {!! Form::select('method',mconfig('evaluation.options.prescription_method'),null,['class'=>'form-control', 'id' => 'pre_method'])!!}
                                  </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td>
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding: 0 !important;">
                                   <input type="text" name="duration" id = "pre_duration" placeholder="E.g 3" class='form-control' required />
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding: 0 !important;">
                                  {!! Form::select('time_measure',mconfig('evaluation.options.prescription_duration'),null,['class'=>'form-control', 'id' => 'pre_time_measure'])!!}
                                </div>
                              </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Substitution Allowed? (Check if yes) </th>
                            <td>
                                <input type="checkbox" name="allow_substitution" class = "checkbox" id = "pre_allow_substitution" style="width: 20px !important; height: 20px !important;" required />
                            </td>
                        </tr>

                        <tr>
                            <th>Regular prescription? (Check if yes) </th>
                            <td>
                                <input type="checkbox" name="type" class = "checkbox" id = "pre_type" style="width: 20px !important; height: 20px !important;" required />
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <button type="submit" class="btn btn-info " id="savePrescriptionForDischarge">
                                    <i class="fa fa-save"></i> Prescribe
                                </button>
                            </td>
                        </tr>
                    </table>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important';">
                        <table class="table table-stripped table-hover" id = "discharge-prescriptions-table">
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

                    <div class="modal fade" id="modal-cancel-discharge-prescription">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h3>Are you sure you want to cancel this prescription?</h3>
                                    <label>If yes, you must provide a reason below</label>
                                    <textarea name="cancel_discharge_prescription_reasons" id="cancel_discharge_prescription_reasons" class="form-control" rows="3" cols = "10" required></textarea>
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
                    <button type="button" class="btn btn-lg btn-primary" id = "btnDischarge"><i class="fa fa-save"></i> Discharge</button>&nbsp;<button type="button" class="btn btn-default" id = "print_summary" style="display: none !important;"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
          
          </form>
        @else
            {{-- Request Discharge Form --}}
             <form>  
                <div class="form-group">
                    <label class="control-label col-md-4" style="padding: 0 !important;">Reason</label>
                    <div class="col-md-8">
                        <textarea name="discharge_reason" id="discharge_reason" class="form-control" rows="3" cols="10" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-offset-4 col-md-9 col-lg-8">
                    <br/><br/>
                    <div class="pull-right">
                        <button type="button" class="btn btn-lg btn-primary" id = "request-discharge"><i class="fa fa-save"></i> Request Discharge</button>
                    </div>
                </div>
            </form>

        @endif
    @else
        <div class="alert alert-info" style="font-size: 1.2em;">
            <strong><i class="fa fa-exclamation-circle"></i></strong> This patient has already been discharged <br/>
            <button type="button" class="btn btn-default" id = "print_summary" style="display: block !important;"><i class="fa fa-print"></i> Print Discharge Summary</button>
        </div>
    @endif

      <script>
            var INSURANCE = false;
            var STOCK_URL = "{{route('api.inventory.getstock')}}";
            var PRODUCTS_URL = "{{route('api.inventory.get.products')}}";
            var VISIT_ID = "{{ $admission->visit_id }}";
            var ADMISSION_ID = "{{ $admission->id }}";
            var USER_ID = "{{ Auth::user()->id }}";
            var PRESCRIPTIONS_URL = "{{ url('/api/inpatient/v1/prescriptions/discharge') }}";
            var PRESCRIPTIONS_DELETE_URL = "{{ url('/api/inpatient/v1/prescriptions/delete') }}";
            var DISCHARGE_POST_URL = "{{ url('/api/inpatient/v1/discharge') }}";
            var REQUEST_DISCHARGE_POST_URL = "{{ url('/api/inpatient/v1/discharge/request') }}";
            var SUMMARY_URL = "{{ url('/inpatient/summary/'.$admission->visit_id.'') }}";
        </script>

        <script src="{!! m_asset('evaluation:js/prescription.js') !!}"></script>

        <script type="text/javascript">
            $(document).ready(function(){

               $("#print_summary").click(function(e){
                    e.preventDefault();
                    var mywindow = window.open(SUMMARY_URL,"","top=50,left=400,  right=400,menubar=no,toolbar=no,scrollbars=yes,resizable=no,status=no");
                    mywindow.print();
                    // mywindow.close();
               });
                
                // $("#discharge-prescriptions-table").dataTable();

                $("#timeofdeath").timepicker({ 'scrollDefault': 'now' });

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

                $('#btnDischarge').click(function(e){
                    e.preventDefault();

                    var type = $("#discharge_type").val();

                    let data = JSON.stringify({
                        visit_id : VISIT_ID,
                        admission_id: ADMISSION_ID,
                        doctor_id: USER_ID,
                        to_come_again : $("#to_come_again").val(),
                        principal_diagnosis: $("#principal_diagnosis").val(),
                        other_diagnosis: $("#other_diagnosis").val(),
                        complaints: $("#complaints").val(),
                        discharge_condition: $("#discharge_condition").val(),
                        investigations_courses: $("#investigations_courses").val(),
                        timeofdeath: $("#timeofdeath").val(),
                        dateofdeath: $("#dateofdeath").val(),
                        case_note: $("#caseNote").val(),
                        type: type
                    });

                 $.ajax({
                    type: "POST",
                    url: DISCHARGE_POST_URL,
                    data: data,
                    success: function (resp) {
                        if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#print_summary").css("display","block");
                        }else{
                            console.log(data);
                            alertify.error(resp.message);
                        }
                    },
                    error: function (resp) {
                        console.log(data);
                        alertify.error(resp.message);
                    }
                });
            });


            $('#savePrescriptionForDischarge').click(function(e){
                e.preventDefault();
                let pre_type = ($("#pre_type").is(":checked")) ? 1 : 0;
                let data = JSON.stringify({
                            visit : VISIT_ID,
                            admission_id: ADMISSION_ID,
                            user: USER_ID,
                            drug: $("#item_1").val(),
                            take: parseInt($("#pre_take").val()),
                            whereto: parseInt($("#pre_whereto").val()),
                            method: parseInt($("#pre_method").val()),
                            duration: parseInt($("#pre_duration").val()),
                            time_measure: parseInt($("#pre_time_measure").val()),
                            allow_substitution: $("#pre_allow_substitution").is(":checked"),
                            type: pre_type,
                            for_discharge: 1
                        });

                 $.ajax({
                    type: "POST",
                    url: PRESCRIPTIONS_URL,
                    data: data,
                    success: function (resp) {
                        // add table rows
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            // Append to Respective row
                                let data = resp.data;
                                // Append to Regular prescription table
                                data.map( (item, index) => {
                                    return(
                                        $("#discharge-prescriptions-table > tbody").append("<tr id = 'discharge_row_"+ item.id +"'>\
                                            <td>"+ item.drug +"</td>\
                                            <td>" + item.dose + "</td>\
                                            <td>"+ item.prescribed_by +"</td>\
                                            <td>"+ item.prescribed_on +"</td>\
                                            <td><div class='btn-group'>\
                                            <button type='button' class='btn btn-info'><i class = 'fa fa-exclamation-circle'></i> Dispensing</button>\
                                            <button type='button' class='btn btn-danger cancel-discharge-prescription' id = '"+ item.id +"'><i class = 'fa fa-times' ></i> Cancel</button>\
                                        </div></td></tr>")
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
            });

            $('body').on('click', '.cancel-discharge-prescription',function(e){
                e.preventDefault();
                let id =  $(this).attr('id');
                $(".yes-cancel-discharge-prescription").attr('id', id); 
                $("#modal-cancel-discharge-prescription").modal();
            });

            $('.yes-cancel-discharge-prescription').click(function(e){
                var id = $(this).attr('id');
                var reason = $.trim($("#cancel_discharge_prescription_reasons").val());
                if(reason.length > 0){
                    $.ajax({
                        type: "POST",
                        url: PRESCRIPTIONS_DELETE_URL,
                        data: JSON.stringify({  
                            visit_id : VISIT_ID,
                            admission_id: ADMISSION_ID,
                            user_id: USER_ID,
                            id : id, 
                            reason: reason 
                        }),
                        success: function (resp) {
                             if(resp.type === "success"){
                                alertify.success(resp.message);
                                $("#discharge_row_"+id+"").remove();
                                $("#modal-cancel-discharge-prescription").modal('toggle');
                            }else{
                                 alertify.error(resp.message);
                            }
                        },
                        error: function (resp) {
                            alertify.error(resp.message);
                        }
                    });
                }else{
                    alertify.error("You must first provide a reason for cancellation!");
                }
            });  

             $('#request-discharge').click(function(e){
                var reason = $.trim($("#discharge_reason").val());
                if(reason.length > 0){
                    $.ajax({
                        type: "POST",
                        url: REQUEST_DISCHARGE_POST_URL,
                        data: JSON.stringify({  
                            visit_id : VISIT_ID,
                            admission_id: ADMISSION_ID,
                            doctor_id: USER_ID,
                            reason: reason
                        }),
                        success: function (resp) {
                             if(resp.type === "success"){
                                alertify.success(resp.message);
                            }else{
                                alertify.error(resp.message);
                            }
                        },
                        error: function (resp) {
                            alertify.error(resp.message);
                        }
                    });
                }else{
                    alertify.error("You must first provide a reason for discharge!");
                }
            });                 


        });
      </script>
   
</div>