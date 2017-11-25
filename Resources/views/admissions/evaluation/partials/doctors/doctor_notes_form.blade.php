<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Doctors Notes Form</h5>
    </div>

    <div class="panel-body">
        <form id="doctor_notes" action="{{ url('/inpatient/manage/notes') }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $visit->id }}" required>

            <div class="form-group">
                <label>Write your notes here:</label>
                <textarea name="notes" id="doctors-notes" class="form-control summernote" rows="10" placeholder="Doctor's Notes..." required autofocus></textarea>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                <button type="button" class="btn btn-primary col-md-1" id="save-note">Save Notes</button>
                <!-- <button type="button" class="btn btn-default" id = "capture-modal"><i class = "fa fa-camera"></i> Capture</button> -->
            </div>
            
        </form>
    </div>

    <!-- Start Scripts -->
    {{-- @push('scripts') --}}

    {{-- @endpush --}}
    <!-- End Scripts -->
</div>