<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Record Patient Vitals</h5>
    </div>
    <div class="panel-body">
        <form id = "vitals-form">
            {{ csrf_field() }}
            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $visit->id }}" required>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding:0 !important;">
                <br>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding: 0 !important;">
                        <label for="" class="control-label">Date recorded:</label>
                        <input type="date" class="form-control" name="date_recorded" id ="date_recorded" value = "{{ \Carbon\Carbon::now('Africa/Nairobi')->toDateString() }}" required>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <label for="" class="control-label">Time recorded:</label>
                        <input type="text" class="form-control" name="time_recorded" id ="time_recorded" value = "{{ \Carbon\Carbon::now()->format('H:i A') }}" required>
                    </div>
                </div>                    

                <label for="" class="control-label">Weight:(Kgs)</label>
                <input type="number" class="form-control" name="weight" id ="weight" value = "{{ (isset($admission->vitals->weight)) ? $admission->vitals->weight : "" }}" required>

                <label for="" class="control-label">Height:(Metres)</label>
                <input type="text" class="form-control" name="height" id ="height" value = "{{ (isset($admission->vitals->height)) ? $admission->vitals->height : "" }}" required>

                <label for="" class="control-label">BP Systolic:[mm/hg]</label>
                <input type="number" class="form-control" name="bp_systolic" id = "bp_systolic">

                <label for="" class="control-label">BP Diastolic:[mm/hg]</label>
                <input type="number" class="form-control" name="bp_diastolic" id = "bp_diastolic">

                <label for="" class="control-label">Pulse:[Per Min]</label>
                <input type="number" class="form-control" name="pulse" id="pulse">

                <label for="" class="control-label">Respiration:[Per min]</label>
                <input type="number" class="form-control" name="respiration" id = "respiration">

                <label for="" class="control-label">Temperature:[Celsius]</label>
                <input type="number" class="form-control" name="temperature" id = "temperature">

                <label for="" class="control-label">Temperature Location:</label>
                <select class="form-control" name="temperature_location" id = "temperature_location">
                    <option value="Oral">Oral</option>
                    <option value="Tympanic Membrane">Tympanic Membrane</option>
                    <option value="Axillary">Axillary</option>
                    <option value="Temporal Artery">Temporal Artery</option>
                    <option value="Rectal">Rectal</option>
                </select>

                <label for="" class="control-label">Oxygen Saturation:[%]</label>
                <input type="number" class="form-control" name="oxgyen" id = "oxygen">                   
            </div>


            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding:0 0 0 5px !important;">
                <br>
                <label for="" class="control-label">Waist Circumference:[cm]</label>
                <input type="number" class="form-control" name="waist" id = "waist">

                <label for="" class="control-label">Hip Circumference:[cm]</label>
                <input type="number" class="form-control" name="hip" id = "hip">
                {{--  <label for="" class="control-label">Waist to Hip Ratio</label>
                <input type="number" class="form-control" disabled name="waist_hip_ratio">

                <label for="" class="control-label">BMI:[%]</label>
                <input type="number" class="form-control bmi" disabled name="bmi" id = "bmi">

                <label for="" class="control-label">BMI Status:</label>
                <input type="text" class="form-control" disabled name="bmi_status" id = "bmi_status"> --}}
                
                <label for="" class="control-label">Blood Sugar:</label>
                <input type="number" class="form-control" name="blood_sugar" id = "blood_sugar">

                <label for="" class="control-label">Blood Sugar Units:</label>
                <select name="blood_sugar_units" id="blood_sugar_units" class="form-control" required="required">
                    <option value="mmol/L">mmol/L</option>
                    <option value="mg/dL">mg/dL</option>
                </select>

                <label for="" class="control-label">Allergies:</label>
                <input type="text" class="form-control" name="allergies" id = "allergies" value="None">

                <label for="" class="control-label">Chronic Illnesses:</label>
                <input type="text" class="form-control" name="chronic_illnesses" id = "chronic_illnesses" value="None">

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12" style="padding: 0 !important;">
                <br>
                <button type="button" class="btn  btn-primary" id = "record-vitals">Record</button>
            </div>
        </form>
    </div>
</div>        