<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Care Plan</h5>
    </div>

    <div class="panel-body">
        <div class="row">
            {!! Form::open(['url' => "inpatient/evaluations/$visit->id/care-plan"]) !!}

                {!! Form::hidden('visit_id', $visit->id) !!}

                {!! Form::hidden('user_id', Auth::user()->id) !!}

                {!! Form::hidden('admission_id', $visit->admission->id) !!}   

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Nursing Diagnosis') !!}
                        {!! Form::textarea('diagnosis', null, ['class'=>'form-control', 'rows'=>'4']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Nursing Assesment') !!}
                        {!! Form::textarea('assessment', null, ['class'=>'form-control', 'rows'=>'4']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Expected Outcome') !!}
                        {!! Form::textarea('expected_outcome', null, ['class'=>'form-control', 'rows'=>'4']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Interventon/Implementation') !!}
                        {!! Form::textarea('intervention', null, ['class'=>'form-control',  'rows'=>'4']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Scientific Rationale/Reasons') !!}
                        {!! Form::textarea('reasons', null, ['class'=>'form-control', 'rows'=>'4']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Evaluation') !!}
                        {!! Form::textarea('evaluation', null, ['class'=>'form-control', 'rows'=>'4']) !!}
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::submit('Save', ['class'=>'btn btn-primary col-md-4']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>    
    </div>
</div>    