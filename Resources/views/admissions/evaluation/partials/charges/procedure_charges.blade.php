<div class="panel panel-info">
    <div class="panel-heading">
        Procedure Charges <b class="pull-right">TOTAL: Kshs {{ $procedures['total'] }}</b>
    </div>
    <div class="panel-body">
        <h4 style="font-weight: bold;">Doctor Procedures</h4>
        @include('inpatient::admissions.evaluation.partials.charges.procedures.doctor')

        <h4 style="font-weight: bold;">Nurse Procedures</h4>
        @include('inpatient::admissions.evaluation.partials.charges.procedures.nurse')
    </div>
</div>