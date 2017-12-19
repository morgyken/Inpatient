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
                    {!! Form::select('time_measure', mconfig('evaluation.options.prescription_duration'),null,['class'=>'form-control', 'id' => 'time_measure'])!!}
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th>Units</th>
        <td>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                {{Form::text('quantity',1,['class'=>'form-control'])}}
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary btn-sm">Add Drug</button>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>


<script>
    var INSURANCE = false;
    var STOCK_URL = "{{route('api.inventory.getstock')}}";
    var PRODUCTS_URL = "{{route('api.inventory.get.products')}}";
    var VISIT_ID = "{{ $admission->visit_id }}";
    var ADMISSION_ID = "{{ $admission->id }}";
    var USER_ID = "{{ Auth::user()->id }}";
    var PRESCRIPTIONS_URL = "{{ url('/api/inpatient/v1/prescriptions') }}";
    var PRESCRIPTIONS_DELETE_URL = "{{ url('/api/inpatient/v1/prescriptions/delete') }}";
    var PRESCRIPTIONS_STOP_URL = "{{ url('/api/inpatient/v1/prescriptions/stop') }}";
    var ADMINISTER_PRESCRIPTION_URL = "{{ url('/api/inpatient/v1/prescriptions/administer') }}";
    var GET_LOGS_URL = "{{ url('/api/inpatient/v1/prescriptions/administration')}}";
    var DELETE_ADMINISTRATION_URL = "{{ url('/api/inpatient/v1/prescriptions/administration/delete') }}";
</script>
<script src="{!! m_asset('evaluation:js/prescription.js') !!}"></script>
