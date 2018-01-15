<div class="panel panel-info">
    <div class="panel-heading">
        <h5>Previous Recorded Vitals</h5>
    </div>

    <div class="panel-body">
        <table class="table table-condensed" id="in_table" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Temperature</th>
                <th>BP Systolic</th>
                <th>BP Diastolic</th>
                <th>Respiration</th>
                <th>Pulse Rate</th>
                <th>Oxygen (%)</th>
                <th>Recorded At</th>
            </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @foreach($vitals as $vital)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $vital->temperature }}</td>
                        <td>{{ $vital->bp_systolic }}</td>
                        <td>{{ $vital->bp_diastolic }}</td>
                        <td>{{ $vital->respiration }}</td>
                        <td>{{ $vital->pulse }}</td>
                        <td>{{ $vital->oxygen }}</td>
                        <td>{{ \Carbon\Carbon::parse($vital->created_at)->toDateTimeString() }}</td>
                    </tr>

                    @php $count++; @endphp

                @endforeach
            </tbody>
        </table>
    </div>
</div>