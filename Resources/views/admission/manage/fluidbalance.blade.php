<div role="tabpanel" id="fluidbalance" class="tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <br/>
        <div class="alert alert-info" style="font-size: 1.2em;">
            <strong>NOTE: </strong>Please record quantity of fluid administered at its conclusion. Also note how much has been given from present bottle and how much drainage fluid by 6 am
        </div>
        <form role="form" id = "fluid_balance_form">
            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $admission->visit_id }}" required>

            <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">  
                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                    <label>Time Recorded</label>
                    <input type="text" name="fb_time_recorded" id = "fb_time_recorded" class="form-control" value = "{{ \Carbon\Carbon::now()->format('H:i a') }}" required/>
                </div>
                 <div class="form-group col-xs-12 col-sm-12 col-md-6">
                    <label>Date Recorded</label>
                    <input type="date" name="fb_date_recorded" id = "fb_date_recorded" class="form-control" value = "{{ \Carbon\Carbon::now('Africa/Nairobi')->toDateString() }}" required/>
                </div>
            </div>

            <div class = "col-xs-12 col-sm-12 col-md-6 col-lg-6 right-border">  
                <h3>INTAKE (in ml.)</h3><hr/>
                <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">  
                    <h4>Intravenous</h4>
                    <div class="form-group col-xs-12 col-sm-12 col-md-4">
                        <label>Type</label>
                        <input type="text" name="intravenous_type" id = "intravenous_type" class="form-control"/>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-4">
                        <label>Bottle</label>
                        <input type="text" name="bottle" id = "bottle" class="form-control"/>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-4">
                        <label>Infused</label>
                        <input type="text" name="infused" id = "infused" class="form-control"/>
                    </div>
                </div>

                <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">  
                    <h4>Alimentary</h4>
                    <div class="form-group col-xs-12 col-sm-12 col-md-4">
                        <label>Type</label>
                        <input type="text" name="alimentary_type" id = "alimentary_type" class="form-control"/>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-4">
                        <label>Amount</label>
                        <input type="number" name="alimentary_amount" id = "alimentary_amount" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class = "col-xs-12 col-sm-12 col-md-6 col-lg-6">   
                <h3>OUTPUT (in ml.)</h3><hr/>
                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                    <label>Vomit</label>
                    <input type="number" name="vomit" id = "vomit" class="form-control"/>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                    <label>Stool</label>
                    <input type="number" name="stool" id = "stool" class="form-control"/>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                    <label>N/Gast</label>
                    <input type="number" name="ngast" id = "ngast" class="form-control"/>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                    <label>Others</label>
                    <input type="text" name="others" id = "others" class="form-control"/>
                </div>
                <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">  
                    <h4>URINE</h4>
                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                        <label>Amount</label>
                        <input type="number" name="urine_amount" id = "urine_amount" class="form-control"/>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                        <label>Specific Gravidity</label>
                        <input type="number" name="specific_gravidity" id = "specific_gravidity" class="form-control"/>
                    </div>
                </div>
            </div>          

            <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                <h4>Instructions for Intravenous Infusion:</h4>
                <textarea name = "intravenous_infusion" id = "intravenous_infusion" class ="form-control summernote"></textarea>
            </div>

            <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                <h4>Other Instructions:</h4>
                <textarea name = "other_instructions" id = "other_instructions" class ="form-control summernote"></textarea>
            </div>

            <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12"> <br/>
                <button type="button" class="btn btn-primary" id = "save-fb"><i class = "fa fa-save"></i> Save</button>&nbsp;
            </div>
        </form>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
            <h3>Previous Fluid Balance Info.</h3><hr/>            

            <div class="table-responsive">
                <table class="table table-stripped table-bordered table-hover" id = "fb-table">
                    <thead>
                        <tr>
                            <th style="border: none !important;border-right: 1px solid #f4f4f4 !important;"></th>
                            <th colspan="4" class="text-center">INTAKE (in ml.)</th>
                            <th colspan="6" class="text-center">OUTPUT (in ml.)</th>
                        </tr>
                        <tr>
                            <th style="border: none !important;border-right: 1px solid #f4f4f4 !important;"></th>
                            <th colspan="3" class="text-center">Intravenous</th>
                            <th colspan = "2" class="text-center">Alimentary</th>
                            <th colspan="4"></th>
                            <th colspan="2" class="text-center">URINE</th>
                        </tr>
                        <tr>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Bottle</th>
                            <th>Infused</th>
                            <th>Type</th>
                            <th>Amount</th>
                           <th>Vomit</th>
                            <th>Stool</th>
                            <th>N/Gast</th>
                            <th>Others</th>
                            <th>Amount</th>
                            <th>Specific Gravity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fluidbalances as $fb)
                        <tr>
                            <td>{{ $fb['recorded_on'] }}</td>
                            <td>{{ $fb['intake_intravenous']['type'] }}</td>
                            <td>{{ $fb['intake_intravenous']['bottle'] }}</td>
                            <td>{{ $fb['intake_intravenous']['infused'] }}</td>
                            <td>{{ $fb['intake_alimentary']['type'] }}</td>
                            <td>{{ $fb['intake_alimentary']['amount'] }}</td>
                            <td>{{ $fb['output']['vomit'] }}</td>
                            <td>{{ $fb['output']['stool'] }}</td>
                            <td>{{ $fb['output']['ngast'] }}</td>
                            <td>{{ $fb['output']['others'] }}</td>
                            <td>{{ $fb['output']['urine_amount'] }}</td>
                            <td>{{ $fb['output']['specific_gravidity'] }}</td>
                        </tr>  
                        @endforeach   
                    </tbody>
                    <tfoot>
                        <tr rowspan = "4">
                            <td colspan="3">INTRAVENOUS/ALIMENTARY</td>
                            <td><b>Total Intake</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Total Output</b></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-view-fluid-balance">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">View Fluid Balance</h4>
                    </div>
                    <div class="modal-body">
                        <p id = "fb-view"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete-fb">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Are you sure you want to delete this data?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger yes-delete-fb">Yes</button>
                        <button type="button" class="btn btn-success" id = "no-delete-fb"  data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    <script type="text/javascript">
        var FB_TABLE_URL = "{{ url('/api/inpatient/v1/fluidbalances') }}";
        var FB_TABLE_GET_URL = "{{ url('/api/inpatient/v1/fluidbalances/admission/'.$admission->id.'') }}";
        var VISIT_ID = "{{ $admission->visit_id }}";
        var ADMISSION_ID = "{{ $admission->id }}";
        var USER_ID = "{{ Auth::user()->id }}";
    </script>
        
    <script type="text/javascript">

        $(document).ready(function(){
            
            $("#fb-table").dataTable({
                // ajax: FB_TABLE_GET_URL
            });

            $('.summernote').summernote();

            $("#fb_time_recorded").timepicker({ 'scrollDefault': 'now' });

            $('#save-fb').click(function(e){
                e.preventDefault();

                 $.ajax({
                    type: "POST",
                    url: FB_TABLE_URL,
                    data: JSON.stringify({
                            visit_id : VISIT_ID,
                            admission_id: ADMISSION_ID,
                            user_id: USER_ID,
                            time_recorded : $("#fb_time_recorded").val(),
                            date_recorded : $("#fb_date_recorded").val(),
                            intravenous_type: $("#intravenous_type").val(),
                            bottle: $("#bottle").val(),
                            infused: $("#infused").val(),
                            alimentary_type: $("#alimentary_type").val(),
                            alimentary_amount: $("#alimentary_amount").val(),
                            vomit: $("#vomit").val(),
                            stool: $("#stool").val(),
                            ngast: $("#ngast").val(),
                            others: $("#others").val(),
                            urine_amount: $("#urine_amount").val(),
                            specific_gravidity: $("#specific_gravidity").val(),
                            intravenous_infusion: $("#intravenous_infusion").val(),
                            other_instructions: $("#other_instructions").val()
                     }),
                    success: function (resp) {
                        
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#fb-table").api().ajax.reload();
                        }else{
                            alertify.error(resp.message);
                        }
                    },
                    error: function (resp) {
                        alertify.error(resp.message);
                    }
                });
            });

            $('body').on('click','.view-fb', function(e){
                e.preventDefault();
                let id =  $(this).attr('id');
                $("#modal-view-fb").modal();
            });

            $('body').on('click','.delete-fb', function(e){
                e.preventDefault();
                let id =  $(this).attr('id');
                $(".yes-delete-fb").attr('id', id); 
                $("#modal-delete-fb").modal();
            });

            $('.yes-delete-fb').click(function(e){
                var id = $(this).attr('id');
                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/fluidbalances/delete') }}",
                    data: JSON.stringify({ id : id }),
                    success: function (resp) {
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#fb_row_"+id+"").remove();
                            $("#modal-delete-fb").modal('toggle');
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
