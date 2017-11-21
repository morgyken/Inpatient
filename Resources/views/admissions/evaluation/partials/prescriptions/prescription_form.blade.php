<div class="panel panel-info" id="focus">
    <div class="panel-heading">
        <h5>Drug Requisition &amp; Administration</h5>
    </div>
    <div class="panel-body">
        {!! Form::open(['class'=>'form-horizontal', 'url'=>'inpatient/admissions/'.$admission->id.'/manage/prescriptions']) !!}
            
            <!-- Hidden Fields -->
            {!! Form::hidden('user', Auth::user()->id) !!}

            {!! Form::hidden('visit', $admission->visit_id) !!}

            {!! Form::hidden('admission_id', $admission->id) !!}

            <!-- End Hidden Fields -->

            <div class="form-group">   
                <div class="col-md-3">
                    <label for="drug">Drug to Prescribe</label>  
                </div> 
                <div class="col-md-9">
                    <select name="drug" id="item_0" class="form-control select2-single" required></select>
                </div> 
            </div>

            <div class="form-group">   
                <div class="col-md-3">
                    <label for="drug">Drug Dosage</label>  
                </div> 
                <div class="col-md-3">
                    {!! Form::text('take', null, ['id'=>'take', 'class'=>'form-control']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::select('whereto', mconfig('evaluation.options.prescription_whereto'),null,['class'=>'form-control', 'id' => 'whereto'])!!}
                </div> 
                <div class="col-md-3">
                    {!! Form::select('method', mconfig('evaluation.options.prescription_method'),null,['class'=>'form-control', 'id' => 'method'])!!}
                </div>
            </div>

            <div class="form-group">   
                <div class="col-md-3">
                    <label for="drug">Medication Duration</label>  
                </div> 
                <div class="col-md-3">
                    {!! Form::text('duration', null, ['id'=>'duration', 'placeholder'=>'E.g 3', 'class'=>'form-control', 'required'=>'required']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::select('time_measure',mconfig('evaluation.options.prescription_duration'),null,['class'=>'form-control', 'id' => 'time_measure'])!!}
                </div> 
            </div>

            <div class="form-group">   
                <div class="col-md-3">
                    <label for="drug">Drugs to Dispense</label>  
                </div> 
                <div class="col-md-9">
                    {!! Form::text('quantity', null, ['id' => 'dispense', 'class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group">   
                <div class="col-md-12">
                    {!! Form::submit('Save Prescription', ['class' => 'btn btn-primary btn col-md-2']) !!}
                </div>
            </div>

        {!! Form::close() !!}
    </div>
    <!-- Start Scripts -->
    {{-- @push('scripts') --}}
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

    <script>
        $("#take").keyup(calculateDrugsToDispense);

        $('#method').change(calculateDrugsToDispense);
        
        $('#time_measure').change(calculateDrugsToDispense);

        $('#duration').keyup(calculateDrugsToDispense);

        function calculateDrugsToDispense(event)
        {
            let dosage = parseInt($('#take').val());

            let rate = parseInt(getRate());

            let time = getTime();

            $('#dispense').val(dosage * rate * time);
        }

        function getRate()
        {
            let content = $('#method').find("option:selected").text();

            if(content == 't.i.d')
            {
                return 3;
            }
            if(content == 'q.i.d')
            {
                return 4;
            }
            if(content == 'STAT' || content == 'O.D')
            {
                return 1;
            }

            return 2;
        }

        function getTime()
        {
            let measure = $('#time_measure').find("option:selected").text();

            let duration = $('#duration').val() ? parseInt($('#duration').val()) : 0;

            if(measure.indexOf('day') !== -1)
            {
                return 1 * duration;
            }

            if(measure.indexOf('week') !== -1)
            {
                return 7 * duration;
            }

            if(measure.indexOf('month') !== -1)
            {
                return 30 * duration;
            }

            if(measure.indexOf('year') !== -1)
            {
                return 365 * duration;
            }

            return 0;
        }
    </script>
    {{-- @endpush --}}
    <!-- End Scripts -->
</div>