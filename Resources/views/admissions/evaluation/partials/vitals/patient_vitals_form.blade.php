<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Record Patient Vitals</h5>
    </div>
    <div class="panel-body">
        {!! Form::open(['url' => 'inpatient/evaluations/'.$visit->id.'/patient-vitals', 'id' => 'vitals-form', 'class' => 'row']) !!}

            {!! Form::hidden('visit_id', $visit->id) !!}

            {!! Form::hidden('user_id', Auth::user()->id) !!}

            {!! Form::hidden('admission_id', $visit->admission->id) !!}            

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('Date Recorded') !!}
                    {!! Form::date('date_recorded', \Carbon\Carbon::now('Africa/Nairobi')->toDateString(), ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('Time Recorded') !!}
                    {!! Form::time('time_recorded', \Carbon\Carbon::now()->format('H:i A'), ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Waist Circumference:[cm]') !!}
                    {!! Form::number('waist', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Weight:[Kgs]') !!}
                    {!! Form::number('weight', isset($admission->vitals->weight) ?? $admission->vitals->weight, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Hip Circumference:[cm]') !!}
                    {!! Form::number('hip', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Height:[cm]') !!}
                    {!! Form::number('height', isset($admission->vitals->height) ?? $admission->vitals->height, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Blood Sugar') !!}
                    {!! Form::number('blood_sugar', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('BP Systolic:[mm/hg]') !!}
                    {!! Form::number('bp_systolic', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Blood Sugar Units') !!}
                    {!! Form::select('blood_sugar_units', ['mmol/L'=>'mmol/L', 'mg/dL'=>'mg/dL'], 'mmol/L', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('BP Diastolic:[mm/hg]') !!}
                    {!! Form::number('bp_diastolic', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Allergies') !!}
                    {!! Form::text('allergies', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Pulse:[Per Min]') !!}
                    {!! Form::number('pulse', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Chronic Illnesses') !!}
                    {!! Form::text('chronic_illnesses', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Respiration:[Per min]') !!}
                    {!! Form::number('respiration', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Temperature:[Celsius]') !!}
                    {!! Form::number('temperature', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Temperature Location]') !!}
                    {!! Form::select('temperature_location', [
                        'Oral' => 'Oral', 'Tympanic Membrane' => 'Tympanic Membrane',
                        'Axillary' => 'Axillary', 'Temporal Artery' => 'Temporal Artery', 'Rectal' => 'Rectal'
                    ], 'Oral', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('Oxygen Saturation:[%]') !!}
                    {!! Form::number('oxygen', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::submit('Record Vitals', ['class'=>'btn btn-primary col-md-4']) !!}
                </div>
            </div>

        {!! Form::close() !!}
    </div>
    <script type="text/javascript">
    
    $(document).ready(function(){

    });
</script>
</div>        