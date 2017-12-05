<div class="panel panel-info">
    <div class="panel-heading">
        <h5>Doctors Notes Form</h5>
    </div>

    <div class="panel-body" style="height: 400px;">
        {!! Form::open(['url' => "inpatient/evaluations/$visit->id/doctors" ]) !!}
            <div class="form-group">
                {!! Form::label('title', 'Note Title') !!}
                {!! Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'placeholder' => 'Note Title ...']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('notes', 'Write Doctors Notes') !!}
                {!! Form::textarea('notes', null, ['id' => 'notes', 'class' => 'form-control summernote', 'rows' => '10', 'placeholder' => 'Doctors Notes ...']) !!}
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                <button type="submit" class="btn btn-primary col-md-3" id="save-note">Save Note</button>
                <!-- <button type="button" class="btn btn-default" id = "capture-modal"><i class = "fa fa-camera"></i> Capture</button> -->
            </div>
        {!! Form::close() !!}
    </div>
</div>