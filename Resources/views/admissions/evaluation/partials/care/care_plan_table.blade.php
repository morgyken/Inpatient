<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Previous Care Plans</h5>
    </div>

    <div class="panel-body">
        <table class="table table-stripped" id = "transfusion-table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Assessment</th>
                    <th>Diagnosis</th>
                    <th>Expected</th>
                    <th>Reasons</th>
                    <th>Recorded By</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans as $plan)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($plan->created_at)->toDateTimeString() }}</td>
                        <td>{{ (strlen($plan->assessment) > 0) ? substr($plan->assessment, 0, 20) : 'None' }}</td>
                        <td>{{ (strlen($plan->diagnosis) > 0) ? substr($plan->diagnosis, 0, 20) : 'None' }}</td>
                        <td>{{ (strlen($plan->expected_outcome) > 0) ? substr($plan->expected_outcome, 0, 20) : 'None' }}</td>
                        <td>{{ (strlen($plan->reasons) > 0) ? substr($plan->reasons, 0, 20) : 'None' }}</td>
                        <td>{{ $plan->user->profile->fullName }}</td>
                        <td>Options</td>
                    </tr>
                @endforeach
            </tbody>
        </table>   
    </div>
</div>    