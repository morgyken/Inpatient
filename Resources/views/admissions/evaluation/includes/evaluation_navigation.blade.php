<div class="box box-info">
    <div class="box-body">
<ul class="nav nav-pills">
    <li class="{{ $active != 'doctors' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/doctors') }}">Doctor's Notes</a>
    </li>
    <li class="{{ $active != 'nurses' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/nurses') }}">Nurse's Notes</a>
    </li>
    <li class="{{ $active != 'prescriptions' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/prescriptions') }}">Prescriptions</a>
    </li>
    <li class="{{ $active != 'vitals' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/vitals') }}">Patient Vitals</a>
    </li>
    <li class="{{ $active != 'pressure' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/pressure') }}">Blood Pressure</a>
    </li>
    <li class="{{ $active != 'temperature' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/temperature') }}">Temperature</a>
    </li>
    <li class="{{ $active != 'investigations' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/investigations') }}">Investigations</a>
    </li>
    <li class="{{ $active != 'procedures' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/procedures') }}">Procedures</a>
    </li>
    
</ul>
<ul class="nav nav-pills">
    <li class="{{ $active != 'transfusion' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/transfusion') }}">Blood Transfusion</a>
    </li>
    <li class="{{ $active != 'transfusion' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/transfusion') }}">Fluid Balance</a>
    </li>
    <li class="{{ $active != 'transfusion' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/transfusion') }}">Care Plan</a>
    </li>
    <li class="{{ $active != 'transfusion' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/transfusion') }}">Consumables</a>
    </li>
    <li class="{{ $active != 'transfusion' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/transfusion') }}">Discharge</a>
    </li>
    <li class="{{ $active != 'transfusion' ?: 'active' }}">
        <a href="{{ url('/inpatient/admissions/'. $admission->id.'/manage/transfusion') }}">Charge Sheet</a>
    </li>
</ul>
</div>
</div>
