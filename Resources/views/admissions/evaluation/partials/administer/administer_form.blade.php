<div class="panel panel-info" id="focus">
    <div class="panel-heading">
        <h5>Administer Drugs to Patient</h5>
    </div>
    <div class="panel-body">
        {!! Form::open(['class'=>'form-horizontal', 'url'=>'inpatient/administer']) !!}

            @foreach($dispensed as $dispense)
                <div class="form-group">   
                    <div class="col-md-2">
                        <label for="drug"> {{ $dispense['drug'] }}</label>  
                    </div> 
                    @foreach($dispense['administer'] as $administer)
                        <div class="col-md-1">
                            <label id="label-{{$administer['id']}}" for="{{ $administer['id'] }}" 
                                style=" width: 35px;
                                        font-weight: normal;
                                        font-style: italic;
                                        font-size: 14px;
                                        cursor: pointer">
                                {{ $administer['label'] }}
                            </label>

                            <input type="checkbox" id="{{ $administer['id'] }}" class="check" 
                                value="{{ $administer['administered'] }}" 

                                {{ !$administer['administered'] ?: 'checked disabled' }} 
                            />
                        </div>
                    @endforeach   
                </div>
            @endforeach

        {!! Form::close() !!}
    </div>
    <!-- Start Scripts -->
    {{-- @push('scripts') --}}
    <script>
        $(function () {
            $('.check').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
            });

            $.ajaxSetup({
                headers:
                { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('.check').on('ifChecked', function(event){

                document.getElementById(event.target.id).disabled = true;

                let token = "{{ csrf_token() }}";

                let id = event.target.id;

                let url = "/inpatient/admissions/drugs/administer";

                let data = { 'id': id, '_token': token }

                $.post(url, data).done(function(data){

                    $('#label-'+data.id).html(data.time);

                });
            
            });
        });
    </script>
    {{-- @endpush --}}
    <!-- End Scripts -->
</div>