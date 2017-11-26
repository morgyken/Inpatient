<div class="box box-info">
    <div class="box-body">
<ul class="nav nav-pills">
    <li class="{{ $active != 'doctors' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/doctors') }}">Doctor's Notes</a>
    </li>
    <li class="{{ $active != 'nurses' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/nurses') }}">Nurse's Notes</a>
    </li>
    <li class="{{ $active != 'prescriptions' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/prescriptions') }}">Prescriptions</a>
    </li>
    <li class="{{ $active != 'administer' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/administer') }}">Administer Drugs</a>
    </li>
    <li class="{{ $active != 'patient-vitals' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/patient-vitals') }}">Patient Vitals</a>
    </li>
    <li class="{{ $active != 'blood-pressure' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/blood-pressure') }}">Blood Pressure</a>
    </li>
    <li class="{{ $active != 'temperature' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/temperature') }}">Temperature</a>
    </li>
    <li class="{{ $active != 'investigations' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/investigations') }}">Investigations</a>
    </li>
</ul>
<ul class="nav nav-pills">
    <li class="{{ $active != 'procedures' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/procedures') }}">Procedures</a>
    </li>
    <li class="{{ $active != 'blood-transfusion' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/blood-transfusion') }}">Blood Transfusion</a>
    </li>
    <li class="{{ $active != 'fluid-balance' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/fluid-balance') }}">Fluid Balance</a>
    </li>
    <li class="{{ $active != 'care-plan' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/care-plan') }}">Care Plan</a>
    </li>
    <li class="{{ $active != 'consumables' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/consumables') }}">Consumables</a>
    </li>
    <li class="{{ $active != 'discharge' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/discharge') }}">Discharge</a>
    </li>
    <li class="{{ $active != 'charge-sheet' ?: 'active' }}">
        <a href="{{ url('/inpatient/evaluations/'. $visit->id.'/charge-sheet') }}">Charge Sheet</a>
    </li>
    
</ul>
</div>
</div>
