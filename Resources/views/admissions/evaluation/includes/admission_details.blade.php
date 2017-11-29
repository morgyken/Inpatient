@include('Inpatient::includes.success')
<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-user"></i> {{ $patient->full_name }} | 
        {{ $patient->dob->age }} yr old, {{ $patient->sex }}

        <b class="pull-right">
            <i class="fa fa-h-square"></i> {{ $admission->ward->name }} | 
            <i class="fa fa-bed"></i> {{ $admission->bed->number }}
        </b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6">
                <strong>Number:</strong> @if($patient->patient_no != null) {{ $admission->patient->patient_no }} @else
                    No Number Assigned @endif<br>
                <strong>Account Balance:</strong> Ksh. {{ $admission->patient->account ? $admission->patient->account->balance : 0 }} <br>
            </div>
            <div class="col-lg-6">
                <strong>Admission Date:</strong> {{ date_format($admission->created_at,'l dS M, Y') }}<br>
                <strong>Deposit:</strong> Ksh. {{ $admission->patient->account ? $admission->patient->account->balance : 0 }}<br>
            </div>
        </div>
    </div>
</div>
