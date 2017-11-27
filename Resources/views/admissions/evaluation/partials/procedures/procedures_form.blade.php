<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Doctor &amp; Nurse Procedures</h5>
    </div>
    <div class="panel-body">
        <div class="accordion">
            <h4>Doctor Procedures</h4>
            <div class="treatment_item">
                @include('evaluation::partials.doctor.procedures-doctor')
            </div>
            <h4>Nurse Procedures</h4>
            <div class="treatment_item">
                @include('evaluation::partials.doctor.procedures-nursing')
            </div>
        </div>
    </div>
</div>