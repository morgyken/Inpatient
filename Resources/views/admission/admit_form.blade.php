@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Action to admitting a patient')

@section('content')
    
    @include('Inpatient::includes.success')

    <div class="box box-info">
        <div class="box-body">
            <div class="col-md-6">
                <h4>Patient Information</h4>
                <dl class="dl-horizontal">
                    <dt>Name:</dt><dd>{{ $patient->full_name }}</dd>
                    <dt>Date of Birth:</dt><dd>{{ (new Date($patient->dob))->format('m/d/y') }}
                        <strong>({{ (new Date($patient->dob))->age }} years old)</strong></dd>
                    <dt>Gender:</dt><dd>{{ $patient->sex }}</dd>
                    <dt>Mobile Number:</dt><dd>{{ $patient->mobile }}</dd>
                    <dt>ID number:</dt><dd>{{ $patient->id_no }}</dd>
                    <dt>Email:</dt><dd>{{ $patient->email }}</dd>
                    <dt>Telephone:</dt><dd>{{ $patient->telephone }}</dd>
                    <dt>Admission Time:</dt><dd id="admission_time">{{ new Date() }}</dd>
                     <strong><dt>Account Balance:</dt><dd style="font-size: bold">Kshs.
            @if($patient->account)
                {{ number_format($patient->account->getLatestBalance($patient->id)) }}
            @else
                {{ number_format(0.00) }}
            @endif
            </dd></strong>

                </dl>
                @if(!empty($patient->image))
                    <hr/>
                    <h5>Patient Image</h5>
                    <img src="{{ $patient->image }}"  alt="Patient Image" height="100px"/>
                @else
                    <strong class="text-info">No image</strong>
                @endif
            </div>
            <!-- TODO Work on this-->

        <div class="col-md-6">
            <h4>Check-in details</h4>
            <div class="form-horizontal">
                {!! Form::open(['url'=>['/inpatient/admit_patient'], 'method' => 'POST'])!!}
                <input type="hidden" name="patient_id" value="{{ $patient->id }}"/>
                @if(isset($visit))<input type="hidden" name="visit_id" value="{{ $visit->id }}"/>@endif
                @if(isset($request_id))<input type="hidden" name="request_id" value="{{ $request_id }}"/>@endif
                <div class="form-group req {{  $errors->has('admission_doctor') ? ' has-error' : ''  }}">
                    {!! Form::label('Admission Doctor', 'Admission Doctor'
                    ,['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <select name="admission_doctor" class="form-control" id="admission_doc">
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}">
                                    {{ $doc->profile->last_name }}
                                    {{ $doc->profile->first_name }}
                                </option>
                                @endforeach
                                <option value="other">Other</option>
                        </select>
                        {!! $errors->first('admission_doctor', '<span class="help-block">:message</span>') !!}

                    </div>
                </div>
                <div class="form-group external_doc">
                    <label class="control-label col-md-4">External Doc</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" placeholder="Name of the doctor" name="external_doc" id="specify_doc">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <label class="checkbox-inline"><input  type="checkbox" name="to_nurse" value="1" checked/> Also check in patient to Nurse </label>
                    </div>
                </div>

                <div class="form-group req {{  $errors->has('clinic') ? ' has-error' : ''  }}">
                    {!! Form::label('clinic', 'Clinic',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <p class="form-control-static">{{ get_clinic_name() }}</p>
                    </div>
                </div>

                <div class="form-group req {{  $errors->has('purpose') ? ' has-error' : ''  }}">
                    {!! Form::label('selectedWard', 'Ward',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <select name="ward_id" required id="selectedWard" class="form-control" required>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->id }}">{{ $ward->name }} @Kshs. {{ $ward->cost }} </option>
                            @endforeach
                        </select>
                        {!! $errors->first('ward', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>


                <div class="form-group req {{  $errors->has('bedposition') ? ' has-error' : ''  }}">
                    {!! Form::label('Bed Position', 'Bed Position',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <select name="bedposition_id" id="selectPos" required class="form-control">
                        @foreach($bedpositions as $bedp)
                            <option value="{{ $bedp->id }}">{{ $bedp->name }}</option>
                        @endforeach()
                        </select>
                        {!! $errors->first('bedposition', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group req {{  $errors->has('bed') ? ' has-error' : ''  }}">
                    {!! Form::label('Bed', 'bed',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <select name="bed_id" id="selectPos" required class="form-control">
                        @foreach($beds as $bed)
                            <option value="{{ $bed->id }}">{{ $bed->number }}</option>
                        @endforeach()
                        </select>
                        {!! $errors->first('bed', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{  $errors->has('payment_mode') ? ' has-error' : ''  }}">
                    {!! Form::label('name', 'Payment Mode',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8" id="mode">
                        <input checked name="payment_mode" type="radio" value="cash" id="cash_option"> Cash
                        @if($patient->insured>0)
                            <input name="payment_mode" type="radio" value="insurance" id="insurance_option"> Insurance
                        @endif
                        {!! $errors->first('payment_mode', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="ins form-group {{  $errors->has('scheme') ? ' has-error' : ''  }}" id="schemes">
                    {!! Form::label('scheme', 'Insurance Scheme',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('scheme',get_patient_insurance_schemes($patient->id), old('scheme'), ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('scheme', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>


                <div class="ins form-group {{  $errors->has('scheme') ? ' has-error' : ''  }}" id="schemes">
                    {!! Form::label('scheme', 'Upload Authorization Letter',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <input type="file" class="form-control">
                    </div>
                </div>

                <div class="ins form-group {{  $errors->has('max-allowed') ? ' has-error' : ''  }}" id="schemes">
                    {!! Form::label('scheme', 'Maximum Amount Allowed By Insurance:',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <input type="number" name="max-allowed" class="form-control">
                    </div>
                </div>
                <div class="cash form-group {{  $errors->has('deposit') ? ' has-error' : ''  }}" id="schemes">
                    {!! Form::label('deposit', 'Charge Deposit',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <select name="deposit" id="depositSel" class="form-control">
                            @foreach($deposits as $deposit)
                                <option value="{{ $deposit->id }}">{{ $deposit->name }} @Kshs. {{ $deposit->cost }}</option>
                                @endforeach
                        </select>
                        <div id="errorRe"></div>
                        {!! $errors->first('deposit', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                
                <!-- the admission and nursing charges -->
                    
                 @foreach($admissions as $adm)

                      <div class="form-group ">
                        {{-- {!! Form::label($adm->name, $adm->name,['class'=>'control-label col-md-4']) !!} --}}
                        <div class="col-md-8 col-md-offset-4" id = "recurrent_charges">
                           {{--  <input name="recurrent_charges[]" class="admission" type="checkbox" value="{{ $adm->id }}">
                            {{ $adm->name }} @ price {{ $adm->cost }} --}}
                        </div>
                    </div>

                @endforeach 
                
                <div class="pull-right">
                    <button type="submit" id="admitPatient" class="btn btn-success"><i class="fa fa-user-plus"></i> Admit Patient</button>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>

        <script>
            var checkPayment = function(){
                var pay = $('input[name=payment_mode]:checked').val();
                 if(pay == 'cash'){
                     $(".ins").hide();
                     $(".cash").show();
                 }else{
                     $('.ins').show();
                     $(".cash").hide();
                 }
            };
            var checkOther = function () {
                if($("#admission_doc").val() == 'other'){
                    $("div.external_doc").show();
                }else{
                    $("div.external_doc").hide();
                }
            };
            $('input[name=payment_mode]').change(function () {
                checkPayment();
            });
            $(function () {

                //on submit check if the button has class inactive.
                $("#admitPatient").click(function(e){
                    if($("#admitPatient").hasClass('disabled') && $('input[name=payment_mode]:checked').val()=='cash' ){
                        e.preventDefault();
                    }
                })

                checkBalance();
                checkPayment();
                checkOther();
                setInterval(setTime,1000);

                function setTime(){
                    var dt = new Date();
                    var h =  dt.getHours(), m = dt.getMinutes(), s = dt.getSeconds();
                    (h<10 == 1) ? (h = '0'+h):(h=h);
                    (m<10 == 1) ? (m ='0'+m):(m=m);
                    (s<10 == 1) ? (s ='0'+s):(s=s);

                    var time = (h > 12) ? (h-12 + ':' + m +':' + s +' pm') : (h + ':' + m +':' + s +' am');
                    $("#admission_time").text(time)
                }

                var loadBeds = function(){
                    var urlAvailableBeds = '{{ url('/inpatient/beds/availableBeds/') }}';
                    urlAvailableBeds = urlAvailableBeds + '/' + ($("#selectedWard").val());
                    $.ajax({
                        url:urlAvailableBeds,
                        method:'GET'
                    }).done(function (data) {
                        $("#selectPos").html("");
                        $.each(data, function (index,value) {
                            // console.info("index=>"+index+'value=>'+value.number);
                            $("#selectPos").append("<option value='"+value.id+"'>"+value.name+"</option>")
                        })
                    });
                };
                loadBeds();

                var loadRecurrentCharges = function (){
                    var url = '{{ url('/inpatient/ward') }}';
                    urlRecurrentCharges = url + '/' + ($("#selectedWard").val()) + '/recurrent_charges';
                    $.ajax({
                        url:urlRecurrentCharges,
                        method:'GET'
                    }).done(function (data) {
                        $("#recurrent_charges").html("");
                        $.each(data, function (index,value) {
                            console.log(value);
                            $("#recurrent_charges").append("<input name='recurrent_charges[]' class='admission' type='checkbox' value='"+ value.id +"'> "+ value.name + " @ Ksh. "+ value.cost + "")
                        })

                    });
                }

                loadRecurrentCharges();
                $("#selectedWard").change(function () {
                    loadBeds();
                    loadRecurrentCharges();
                    checkBalance();
                })

            });
            $("#admission_doc").change(function () {
                checkOther();
            });
            $("#depositSel").change(function () {
                checkBalance();
            });

            var checkBalance = function () {
                var url = '{{ url('/inpatient/admit_check') }}';
                var deposit_type =  ($("#depositSel").val());
                var patient_id = '{{ $patient->id }}';
                var ward = $("select#selectedWard").val();

                $.ajax({
                    url:url+'?depositTypeId='+deposit_type+'&patient_id='+patient_id+'&ward_id='+ward,
                    method:'GET'
                }).done(function (data) {
                    if(data.status == 'insufficient'){
                        $("#errorRe").html('');
                        $("#errorRe").removeClass('text-success').addClass('text-danger').html(data.description);
                        $("button.btn").addClass('disabled');
                    }else{
                        $("#errorRe").html('');
                        $("button.btn").removeClass('disabled');
                        $("#errorRe").removeClass('text-danger').addClass('text-success').html(data.description);
                    }
                })
            }
        </script>

@endsection