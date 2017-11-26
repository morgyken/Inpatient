<div class="panel panel-info">
    <div class="panel-heading">
        Prescriptions Table
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed" id="prescribed_drugs">
            <thead>
                <th>Name</th>
                <th>Date/Time</th>
                <th>Prescribed</th>
                <th>Dispensed</th>
                <th>Remaining</th>
                <th>Administered</th>
                <th>Actions</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function(){
            $('#prescribed_drugs').dataTable({
                'ajax': {
                    'url': PRESCRIPTIONS_ENDPOINT,
                },
            });
        });
    </script>
</div>