@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Action to admitting a patient')

@section('content')

@include('Inpatient::includes.success')

<div class="box box-info">
    <div class="panel panel-info">

        <div class="panel-heading">
            <i class="fa fa-user"></i> {{ $admissionRequest->patient->full_name }} | 
            {{ $admissionRequest->patient->dob->age }} yr old, {{ $admissionRequest->patient->sex }}

            <b class="pull-right">{{ get_clinic()->name }}</b>
        </div>

        <div class="panel-body">
            <div class="row"> 
                <div class="col-md-6">
                    <h4>Patient Information</h4>
                    
                    <p class="row"><b class="col-md-4">Patient Name</b><span>{{ $admissionRequest->patient->full_name }}</span></p>
                    <p class="row"><b class="col-md-4">Date of Birth</b><span>{{ $admissionRequest->patient->dob }}</span></p>
                    <p class="row"><b class="col-md-4">Gender</b><span>{{ $admissionRequest->patient->sex }}</span></p>
                    <p class="row"><b class="col-md-4">Mobile Number</b><span>{{ $admissionRequest->patient->mobile }}</span></p>
                    <p class="row"><b class="col-md-4">ID Number</b><span>{{ $admissionRequest->patient->id_no }}</span></p>
                    <p class="row"><b class="col-md-4">Email Address</b><span>{{ $admissionRequest->patient->email }}</span></p>
                    <p class="row"><b class="col-md-4">Telephone Number</b><span>{{ $admissionRequest->patient->telephone }}</span></p>

                </div>
                <div class="col-md-6">
                    <h4>Check In Details</h4>

                    {!! Form::open(['url' => 'inpatient/admissions/'. $admissionRequest->id, 'class' => 'form-horizontal']) !!}

                        <input type="hidden" value="{{ $admissionRequest->id }}" name="inpatient_request_admission_id" />

                        <input type="hidden" value="{{ $admissionRequest->patient->id }}" name="patient_id" />

                        <input type="hidden" value="{{ $admissionRequest->visit_id }}" name="visit_id" />

                        <input type="hidden" value="" name="ward_id" id="wardId" />

                        <div class="form-group req">
                            <label class="col-md-4">Admission Doctor</label>
                            <div class="col-md-8">
                                <select name="doctor_id" id="doctor" class="form-control">
                                    <!-- <option value="" disabled selected>Select a doctor</option> -->
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->profile->full_name }}</option>
                                        @endforeach
                                    <option value="">External Doctor</option>
                                </select>
                                <p class="help-text text-danger">{{ $errors->first('doctor_id') }}</p>
                            </div>
                        </div>

                        <div class="form-group req">
                            <label class="col-md-4" for="">Enter External</label>
                            <div class="col-md-8">
                                <input type="text" id="external" name="external_doctor" class="form-control" disabled>
                                <p class="help-text text-danger">{{ $errors->first('external_doctor') }}</p>
                            </div>
                        </div>

                        <div class="form-group req">
                            <label class="col-md-4" for="">Clinic</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" disabled value="{{ get_clinic()->name }}">
                            </div>
                        </div>
                        
                        <div class="form-group req">
                            <label class="col-md-4" for="">Select a Ward</label>
                            <div class="col-md-8">
                                <select id="ward" class="form-control">
                                    <option value="" disabled selected>Select a ward</option>
                                    @foreach($wards as $ward)
                                        <option value="{{ json_encode($ward) }}">{{ $ward->name }}</option>
                                    @endforeach
                                </select>
                                <p class="help-text text-danger">{{ $errors->first('ward_id') }}</p>
                            </div>
                        </div>
                        
                        <div class="form-group req">
                            <label for="" class="col-md-4">Select a bed</label>
                            <div class="col-md-8">
                                <select name="bed_id" id="beds" class="form-control">
                                </select>
                                <p class="help-text text-danger">{{ $errors->first('bed_id') }}</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-sm col-md-4">
                                    <i class="fa fa-upload"></i> Upload Admission Form
                                </button>

                                <button class="btn btn-success btn-sm col-md-offset-5 col-md-3">
                                    <i class="fa fa-ambulance"></i> Admit Patient
                                </button>
                                
                            </div>
                            
                        </div>
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        {{-- @push('scripts') --}}
            <script>
                if(!$('#doctor').val()){
                    $('#external').removeAttr('disabled');
                }

                $('#doctor').change(function(event){

                    var doctor_id = event.target.value;

                    if(!doctor_id){
                        $('#external').removeAttr('disabled');
                    }else{
                        $('#external').attr('disabled', 'disabled');
                    }
                });

                $('#ward').change(function(event){

                    let ward = JSON.parse(event.target.value);

                    $('#wardId').val(ward.id);

                    let beds = ward.beds;

                    let bedSelect = $('#beds');

                    bedSelect.empty();

                    var optionBuild = "";

                    for(let key = 0; key < beds.length; key++)
                    {
                        optionBuild = optionBuild +  "<option value='"+ beds[key].id +"'>" + 

                            beds[key].number + 
                        
                        "</option>";
                    }

                    bedSelect.append(optionBuild);
                });

            </script>
        {{-- @endpush --}}
    </div>
</div>
@stop        