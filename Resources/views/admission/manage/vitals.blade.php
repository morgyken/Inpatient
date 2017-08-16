<div id="vitals" class="tab-pane fade in active col-lg-12">

    <!--If not recorded add to db else display and enable edit -->
    @if(! count($vitals))
        <h2>Record Patient's Vitals</h2>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <form  method="post" action="" id = "vitals_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding:0 !important;">

                    <label for="" class="control-label">Weight:(Kgs)</label>
                    <input type="number" class="form-control" name="weight" id ="weight">

                    <label for="" class="control-label">height:(Metres)</label>
                    <input type="number" class="form-control" name="height" id ="height">

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

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button class="btn btn-primary">Record</button>
                </div>
            </form>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-6">
            @include('inpatient::admission.graphs.input');
        </div>
       
    @else
        <div class="col-xs-12 col-sm-12 col-lg-8">

            @include('inpatient::admission.graphs.input');

        </div>

    @endif
</div>
