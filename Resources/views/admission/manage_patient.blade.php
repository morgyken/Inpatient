@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Action to admitting a patient')

@section('content')

    <div class="box box-info">
        <div class="box-body">
            <h2>Patient Details</h2>
            <div class="col-lg-6">
                <strong> Name: </strong> {{$patient->name}}<br>
                <strong>Number:</strong>  {{$patient->id}}<br>
                <strong>Ward Name:</strong>  {{\Ignite\Evaluation\Entities\Ward::find($ward->ward_id)->name}}<br>
                <strong>Account Balance:</strong>  <br>
            </div>
            <div class="col-lg-6">

                <strong> Age: </strong> {{$patient->age}}<br>
                <strong>Number:</strong>  {{date_format($admission->created_at,'Y-M-d')}}<br>
                <strong>Bed:</strong>  {{\Ignite\Evaluation\Entities\Bed::find($ward->bed_id)->number}}<br>
                <strong>Name:</strong>  {{$patient->name}}<br>
            </div>
        </div>

    </div>
    <hr>


    <div class="box box-info">
        <div class="box-body">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Patient Vitals</a></li>
                <li><a data-toggle="tab" href="#menu1">Doctor's Note</a></li>
                <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active col-lg-10">
                    <!--If not recorded add to db else display and enable edit -->
                    @if(! count($vitals))
                        <h2>Record Patient's Vitals</h2>
                        <form  method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                            <div class="col-lg-6">

                                <label for="" class="control-label">Weight:(Kgs)</label>
                                <input type="number" class="form-control" name="weight">

                                <label for="" class="control-label">height:(Metres)</label>
                                <input type="number" class="form-control" name="height">

                                <label for="" class="control-label">BP Systolic:[mm/hg]</label>
                                <input type="number" class="form-control" name="bp_systolic">

                                <label for="" class="control-label">BP Diastolic:[mm/hg]</label>
                                <input type="number" class="form-control" name="bp_diastolic">

                                <label for="" class="control-label">Pulse:[Per Min]</label>
                                <input type="number" class="form-control" name="pulse">

                                <label for="" class="control-label">Respiration:[Per min]</label>
                                <input type="number" class="form-control" name="respiration">

                                <label for="" class="control-label">Temperature:[Celsius]</label>
                                <input type="number" class="form-control" name="temperature">

                                <label for="" class="control-label">Temperature Location:[Kgs]</label>
                                <input type="number" class="form-control" name="temperature_location">

                            </div>


                            <div class="col-lg-6">

                                <label for="" class="control-label">Oxygen Saturation:[%]</label>
                                <input type="number" class="form-control" name="oxgyen">

                                <label for="" class="control-label">Waist Circumference:[cm]</label>
                                <input type="number" class="form-control" name="waist">

                                <label for="" class="control-label">Hip Circumference:[cm]</label>
                                <input type="number" class="form-control" name="hip">

                                <label for="" class="control-label">Waist to Hip Ratio</label>
                                <input type="number" class="form-control" name="weight">

                                <label for="" class="control-label">Blood Sugar:</label>
                                <input type="number" class="form-control" name="blood_sugar">

                                <label for="" class="control-label">Blood Sugar:</label>
                                <input type="number" class="form-control" name="blood_sugar_units">

                                <label for="" class="control-label">Allergies:</label>
                                <input type="number" class="form-control" name="allergies">

                                <label for="" class="control-label">Chronic Illnesses:</label>
                                <input type="text" class="form-control" name="chronic_illnesses">

                                <label for="" class="control-label">Nurse's Note:</label>
                                <textArea class="form-control" rows="2" name="nurse_notes"></textArea>


                            </div>

                            <button class="btn btn-primary">Record</button>
                        </form>
                    @else
                        <div class="col-lg-8">

                            @include('graphs.input');

                        </div>

                    @endif
                </div>
                <div id="menu1" class="tab-pane fade">

                    <h2>
                            @if(! $doctor_note)
                                <small class="alert alert-warning">
                            No Doctor Note
                        </small>
                        @else
                            <div>
                            <textarea name="presenting_complaints" id="" class="form-control"
                                      rows="3">{{$doctor_note->complaints}}</textarea>
                            </div>

                            <div>
                            <textarea name="past_medical_history" id="" class="form-control"
                                      rows="3">{{$doctor_note->past_medical_history}}</textarea>
                            </div>

                            <div>
                            <textarea name="examination" id="" class="form-control"
                                      rows="3">{{$doctor_note->examination}}</textarea>
                            </div>

                            <div>
                            <textarea name="presenting_complaints" id="" class="form-control"
                                      rows="3">{{$doctor_note->complaints}}</textarea>
                            </div>

                            <div>
                            <textarea name="diagnosis" id="" class="form-control"
                                      rows="3">{{$doctor_note->diagnosis}}</textarea>
                            </div>

                            <div>
                            <textarea name="investigations" id="" class="form-control"
                                      rows="3">{{$doctor_note->investigations}}</textarea>
                            </div>

                            <div>
                            <textarea name="treatment_plan" id="" class="form-control"
                                      rows="3">{{$doctor_note->treatment_plan}}</textarea>
                            </div>
                            @endif
                    </h2>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Some content in menu 2.</p>
                </div>
            </div>
        </div>

    </div>
@endsection