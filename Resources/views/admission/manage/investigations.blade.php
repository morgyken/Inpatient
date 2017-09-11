<?php
$performed_diagnosis = get_inpatient_investigations($admission->id, ['diagnostics']);
$performed_labs = get_inpatient_investigations($admission->id, ['laboratory']);
$performed_radio = get_inpatient_investigations($admission->id, ['radiology']);
?>
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
                                <h4 class="box-title">Selected procedures</h4>
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
                                        <button class="btn btn-success" id="saveDiagnosis">
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
                    <h4 class="box-title">Previously ordered tests</h4>
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
                            <th>Payment</th>
                            <th>Result</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$performed_diagnosis->isEmpty())
                            @foreach($performed_diagnosis as $item)
                                <tr>
                                    <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->discount}}</td>
                                    <td>{{$item->amount>0?$item->amount:$item->price}}</td>
                                    <td>{!! payment_label($item->is_paid) !!}</td>
                                    @if($item->has_result)
                                        <td><a href="{{route('evaluation.view_result',$item->visit)}}"
                                               class="btn btn-xs btn-success" target="_blank">
                                                <i class="fa fa-external-link"></i> View Result
                                            </a></td>
                                    @else
                                        <td><span class="text-warning"><i class="fa fa-warning"></i> Pending</span></td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif

                        @if(!$performed_labs->isEmpty())
                            @foreach($performed_labs as $item)
                                <tr>
                                    <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->discount}}</td>
                                    <td>{{$item->amount>0?$item->amount:$item->price}}</td>
                                    <td>{!! payment_label($item->is_paid) !!}</td>
                                    <td>
                                        <a href="{{route('evaluation.view_result',$item->visit)}}"
                                           class="btn btn-xs btn-success" target="_blank">
                                            <i class="fa fa-external-link"></i> View Result
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif


                        @if(!$performed_radio->isEmpty())
                            @foreach($performed_radio as $item)
                                <tr>
                                    <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->discount}}</td>
                                    <td>{{$item->amount>0?$item->amount:$item->price}}</td>
                                    <td>{!! payment_label($item->is_paid) !!}</td>
                                    <td>
                                        <a href="{{route('evaluation.view_result',$item->visit)}}"
                                           class="btn btn-xs btn-success" target="_blank">
                                            <i class="fa fa-external-link"></i> View Result
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
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
    var DIAGNOSIS_URL = "{{route('api.evaluation.save_diagnosis')}}";
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
        $('#in_table').dataTable();
        $('#investigationTab input').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>