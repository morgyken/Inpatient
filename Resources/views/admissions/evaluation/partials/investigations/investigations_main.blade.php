<div class="panel panel-info" id="investigationTab">
    <div class="panel-heading">
        <h5>Nurses Notes Form</h5>
    </div>

    <div class="panel-body">
        <div class="accordion">
            <h4>Diagnosis</h4>
            <div class="investigation_item">
                @include('inpatient::admissions.evaluation.partials.investigations.diagnosis_form')
            </div>

            <h4>Laboratory</h4>
            <div class="investigation_item">
                @include('inpatient::admissions.evaluation.partials.investigations.laboratory_form')
            </div>

            <h4>Radiology</h4>
            <div class="investigation_item">
                @include('inpatient::admissions.evaluation.partials.investigations.radiology_form')
            </div>

        </div>
    </div>
</div>    