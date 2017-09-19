<div role="tabpanel" id="investigationTab" class="tab-pane fade">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="accordion">
                    <h4>Diagnosis</h4>
                    <div class="investigation_item">
                        @include('inpatient::admission.manage.partials.investigations-diagnostics')
                    </div>
                    <h4>Laboratory</h4>
                    <div class="investigation_item">
                        @include('inpatient::admission.manage.partials.investigations-lab')
                    </div>
                    <h4>Radiology</h4>
                    <div class="investigation_item">
                        @include('inpatient::admission.manage.partials.radiology')
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12" id="show_selection">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h4 class="box-title">Selected investigations</h4>
                            </div>
                            <div class="box-body">
                                <div id="diagnosisTable">
                                    <table id="diagnosisInfo" class=" table table-condensed">
                                        <thead>
                                        <tr>
                                            <th>Test</th>
                                            <th>Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-success" id="saveInvestigations">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h4 class="box-title">Previously ordered investigations</h4>
                </div>
                <div class="box-body">
                    <table id="in_table" class="table table-condensed">
                        <thead>
                        <tr>
                            <th>Procedure</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>No. Performed</th>
                            <th>Discount</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th>Result</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <style>
        .investigation_item {
            height: 400px;
            overflow-y: scroll;
        }
    </style>
    <script>
        var USER_ID = parseInt("{{ Auth::user()->id }}");
        var VISIT_ID = parseInt("{{ $admission->id }}");
        var DIAGNOSIS_URL = "{{ route('api.evaluation.save_diagnosis') }}";
        var THE_TABLE_URL = "{{ url('/api/inpatient/v1/get/inpatient-investigations/'.$admission->visit_id) }}";

        $(document).ready(function () {
            $('.accordion').accordion({heightStyle: "content"});
            $('#investigationTab input').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>

</div>
