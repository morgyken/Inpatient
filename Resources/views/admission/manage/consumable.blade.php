<div role="tabpanel" id="consumableTab" class="tab-pane fade">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="accordion">
                    <h4>Consumable</h4>
                    <div class="consumable_item">
                        @include('inpatient::admission.manage.partials.consumable-items')
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12" id="show_consumable_selection">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h4 class="box-title">Selected consumables</h4>
                            </div>
                            <div class="box-body">
                                <div id="consumableTable">
                                    <table id="consumableInfo" class=" table table-condensed">
                                        <thead>
                                        <tr>
                                            <th>Consumable</th>
                                            <th>Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-success" id="saveConsumable">
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
                    <h4 class="box-title">Previously ordered consumables</h4>
                </div>
                <div class="box-body">
                    <table id="in_consumables_table" class="table table-condensed">
                        <thead>
                        <tr>
                            <th>Consumable</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>No. Performed</th>
                            <th>Discount</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>
<style>
    .consumable_item {
        height: 400px;
        overflow-y: scroll;
    }
</style>
<script>
    var USER_ID = parseInt("{{ Auth::user()->id }}");
    var VISIT_ID = parseInt("{{ $admission->visit_id }}");
    var CONSUMABLE_URL = "{{url('api/inpatient/v1/saver/consumables')}}";
    var THE_CONSUMABLE_URL = "{{url('/api/inpatient/v1/get/inpatient-consumables/'.$admission->visit_id)}}";
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
        $('#consumableTab input').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    })
    ;
</script>