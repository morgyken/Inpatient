<div class="panel panel-info">
    <div class="panel-heading">
        Discharge Prescriptions Table
    </div>
    <div class="panel-body">
        <table class="table table-stripped table-condensed" id="discharge_prescribed_drugs">
            <thead>
                <th>Drug</th>
                <th>Prescription</th>
                <th>Prescribed</th>
                <!-- <th>Dispensed</th> -->
                <!-- <th>Status</th> -->
                <!-- <th>Remaining</th> -->
                <!-- <th>Administered</th> -->
                <!-- <th>Actions</th> -->
            </thead>
            <tbody>
            </tbody>
        </table>

        <!-- <div class="row">
            <div class="col-md-12" id="save-prescription">
                <button class="col-md-2 btn btn-primary btn-sm" data-toggle="modal" data-target="#administer-modal">
                    Administer Drugs
                </button>   
            </div>
        </div> -->
    </div>
    
    <script>
        var DISCHARGE_PRESCRIPTIONS_ENDPOINT = "{{ url('inpatient/evaluations/'.$visit->id.'/discharge') }}";

        $(document).ready(function(){
            $('#discharge_prescribed_drugs').dataTable({
                'ajax': {
                    'url': DISCHARGE_PRESCRIPTIONS_ENDPOINT,
                },
            });
        });
    </script>
</div>