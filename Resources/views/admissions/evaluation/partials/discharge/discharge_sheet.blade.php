<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Discharge Request Form</h5>
    </div>
    <div class="panel-body">
        
        {!! Form::open(['url' => "inpatient/evaluations/$visit->id/discharge"]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('type', 'Discharge Type') !!}
                        <select name="discharge_type_id" id="type" class="form-control">
                            @foreach($dichargeTypes as $dischargeType)
                                <option value="{{ $dischargeType->id }}">
                                    {{ $dischargeType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('principal', 'Principal Diagnosis') !!}
                        {!! Form::textarea('principal', null, ['id' => 'principal', 'class' => 'form-control', 'rows' => '5', 'placeholder' => 'Principal Diagnosis ...']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('other', 'Other Diagnosis') !!}
                        {!! Form::textarea('other', null, ['id' => 'other', 'class' => 'form-control', 'rows' => '5', 'placeholder' => 'Other Diagnosis ...']) !!}
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('complains', 'Complains at Admission') !!}
                        {!! Form::textarea('complains', null, ['id' => 'complains', 'class' => 'form-control', 'rows' => '5', 'placeholder' => 'Complains at Admission ...']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('investigations', 'Investigations &amp; Hospital Courses') !!}
                        {!! Form::textarea('investigations', null, ['id' => 'investigations', 'class' => 'form-control', 'rows' => '5', 'placeholder' => 'Investigations ...']) !!}
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('conditions', 'Discharge Conditions') !!}
                        {!! Form::textarea('conditions', null, ['id' => 'conditions', 'class' => 'form-control', 'rows' => '5', 'placeholder' => 'Discharge Conditions ...']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('medication', 'Medication at Discharge') !!}
                        {!! Form::textarea('medication', null, ['id' => 'medication', 'class' => 'form-control', 'rows' => '5', 'placeholder' => 'Medication ...']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        @if($visit->discharge)
                            <button type="button" class="btn btn-success" id="save-note">Patient Awaiting Discharge</button>
                        @else
                            {!! Form::submit('Request Discharge', ['class'=>'btn btn-primary small-md-2']) !!}
                        @endif 
                    </div>
                </div>
            </div>
            

        {!! Form::close() !!}
    </div>
</div>