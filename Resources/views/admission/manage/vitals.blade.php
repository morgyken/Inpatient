<div id="vitals" class="tab-pane fade col-lg-12">

    <!--If not recorded add to db else display and enable edit -->
    @if(!count($vitals))
       
        <div class="col-xs-12 col-sm-12 col-md-6">
             <h2>Record Patient's Vitals</h2>
            <form  method="post" action="{{ url('/manage/vitals') }}" id = "vitals_form">

                {{ csrf_field() }}

                <input type="hidden" name="visit" value="{{ $admission->visit_id }}" required>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0 !important;">
                    <label for="" class="control-label">Nurse's Notes</label>
                    <textarea name="nurses_notes" id="nurses_notes" class="form-control" rows="3" placeholder="Nurses Notes"></textarea>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding:0 !important;">
                    <br>
                    <label for="" class="control-label">Weight:(Kgs)</label>
                    <input type="number" class="form-control" name="weight" id ="weight" required>

                    <label for="" class="control-label">Height:(Metres)</label>
                    <input type="text" class="form-control" name="height" id ="height" required>

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

                    <label for="" class="control-label">Temperature Location:</label>
                    <select class="form-control" name="temperature_location">
                        <option value="Oral">Oral</option>
                        <option value="Tympanic Membrane">Tympanic Membrane</option>
                        <option value="Axillary">Axillary</option>
                        <option value="Temporal Artery">Temporal Artery</option>
                        <option value="Rectal">Rectal</option>
                    </select>

                    <label for="" class="control-label">Oxygen Saturation:[%]</label>
                    <input type="number" class="form-control" name="oxgyen">                   
                </div>


                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding:0 0 0 5px !important;">
                    <br>
                    <label for="" class="control-label">Waist Circumference:[cm]</label>
                    <input type="number" class="form-control" name="waist" id = "waist">

                    <label for="" class="control-label">Hip Circumference:[cm]</label>
                    <input type="number" class="form-control" name="hip" id = "hip">
                    <label for="" class="control-label">Waist to Hip Ratio</label>
                    <input type="number" class="form-control" disabled name="waist_hip_ratio">

                    <label for="" class="control-label">BMI:[%]</label>
                    <input type="number" class="form-control bmi" disabled name="bmi" id = "bmi">

                    <label for="" class="control-label">BMI Status:</label>
                    <input type="text" class="form-control" disabled name="bmi_status" id = "bmi_status">
                    
                    <label for="" class="control-label">Blood Sugar:</label>
                    <input type="number" class="form-control" name="blood_sugar">

                    <label for="" class="control-label">Blood Sugar:</label>
                    <input type="number" class="form-control" name="blood_sugar_units">

                    <label for="" class="control-label">Allergies:</label>
                    <input type="number" class="form-control" name="allergies">

                    <label for="" class="control-label">Chronic Illnesses:</label>
                    <input type="text" class="form-control" name="chronic_illnesses">

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12" style="padding: 0 !important;">
                    <br>
                    <button class="btn  btn-primary">Record</button>
                </div>
            </form>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-6">
            @include('inpatient::admission.graphs.input');
        </div>
       
    @else
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <h3>Previous Vitals</h3>
            @if(count($vitals) > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>DateTime</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>BMI</th>
                            <th>Status</th>
                            <th>Temp</th>
                            <th>BP</th>
                            <th>Resp</th>
                            <th>Pulse</th>
                            <th>O<sub>2</sub></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vitals as $v)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($v->created_at)->format('ds M,Y') }}</td>
                                <td>{{ $v->height }}</td>
                                <td>{{ $v->weight }}</td>
                                <td>{{ $v->weight / ($v->height * $v->height) }}</td>
                                <td>
                                    @if( ($v->weight / ($v->height * $v->height)) > 29.9)
                                        Obese
                                    @elseif( ($v->weight / ($v->height * $v->height)) < 30 && ($v->weight / ($v->height * $v->height)) > 24.9)
                                        Overweight
                                    @elseif( ($v->weight / ($v->height * $v->height)) < 24.8 && ($v->weight / ($v->height * $v->height)) > 18.5)
                                        Normal
                                    @elseif( ($v->weight / ($v->height * $v->height)) < 18.5)
                                        Underweight
                                    @endif
                                </td>
                                <td>{{ $v->temperature }}</td>
                                <td>{{ $v->bp_systolic }}/{{ $v->bp_diastolic }}</td>
                                <td>{{ $v->resperation }}</td>
                                <td>{{ $v->pulse }}</td>
                                <td>{{ $v->oxygen }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <br>

                <h3>Nurses Notes</h3>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>DateTime</th>
                            <th>Notes</th>
                            <th>Nurse</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vitals as $v)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($v->created_at)->format('ds M,Y') }}</td>
                                <td>{{ $v->nurse_notes }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert">
                    There are no vitals recorded for this patient
                </div>
           @endif
        </div>

    @endif
</div>
