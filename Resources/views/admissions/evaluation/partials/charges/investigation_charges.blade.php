<div class="panel panel-info">
    <div class="panel-heading">
        Investigation Charges <b class="pull-right">TOTAL: Kshs {{ $investigations['total'] }}</b>
    </div>
    <div class="panel-body">
        <h4 style="font-weight: bold;">Diagnostic Investigations</h4>
        @include('inpatient::admissions.evaluation.partials.charges.investigations.diagnostics')

        <h4 style="font-weight: bold;">Laboratory Investigations</h4>
        @include('inpatient::admissions.evaluation.partials.charges.investigations.laboratory')

        <h4 style="font-weight: bold;">Radiology Investigations</h4>
        @include('inpatient::admissions.evaluation.partials.charges.investigations.radiology')
    </div>
</div>