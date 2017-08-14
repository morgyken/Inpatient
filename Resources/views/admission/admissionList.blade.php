@extends('layouts.app')
@section('content_title','Admitted patient')
@section('content_description','Manage admitted patient')

@section('content')

    <div class="">
        <div class="">
            @if(! count($admissions))
                <div class="box box-info">
                    <div class="box-body">
                        <span class="text-warning">The are no admissions recorded</span>
                    </div>
                </div>

            @else

                <div class="box box-info">
                    <div class="box-body">

                        <table class="table table-stripped table-condensed">
                            <thead>
                            <th>Name.</th>
                            <th>Admission Doc.</th>
                            <th>Ward</th>
                            <th>Bed</th>
                            <th>Cost</th>
                            <th>Admitted At</th>
                            <th>Option</th>
                            </thead>
                            <tbody>
                            @foreach($admissions as $admission)
                                <tr>
                                    <td>{{\Ignite\Reception\Entities\Patients::find($admission->patient_id)->first_name}}
                                        {{\Ignite\Reception\Entities\Patients::find($admission->patient_id)->last_name}}
                                    </td>
                                    @if(is_null($admission->doctor_id))
                                        <td>{{$admission->external_doctor}}</td>
                                        @else
                                        <td>{{\Ignite\Users\Entities\UserProfile::where('user_id',$admission->doctor_id)->first()->first_name}} {{\Ignite\Users\Entities\UserProfile::where('user_id',$admission->doctor_id)->first()->last_name}}</td>
                                        @endif
                                    <td>{{\Ignite\Evaluation\Entities\Ward::find($admission->ward_id)->name}}</td>
                                    <td>{{\Ignite\Evaluation\Entities\Bed::find($admission->bed_id)->number}}</td>
                                    <td>{{$admission->cost}}</td>
                                    <td>{{$admission->created_at}}</td>
                                    <td>
                                       <a href="{{url('/evaluation/patients/visit/'.$admission->visit_id.'/evaluate/nurse')}}"
                                           class="btn btn-success btn-xs"> <i class="fa fa-ellipsis-h"></i> Manage</a>
                                        <a href="{{url('/evaluation/patients/visit/'.$admission->visit_id.'/move')}}"
                                           class="btn btn-primary btn-xs"> <i class="fa fa-share"></i> Move</a>
                                        <a class="btn btn-warning btn-xs" href="{{url('/evaluation/inpatient/request_discharge/'.$admission->visit_id)}}">Request Discharge</a>   
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal fade"  id="myModal" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Checkout patient</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Do you want to check out this patient?</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-warning" id="checkout" >Yes</button>
                                    <button class="btn btn-default" data-dismiss="modal">No, sorry</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


{{--                <table class="table table-stripped">
                    <caption>The Beds List: All The Beds</caption>
                    <thead>
                    <th>Name.</th>
                    <th>Admission Doc.</th>
                    <th>Ward</th>
                    <th>Bed</th>
                    <th>Cost</th>
                    <th>Admitted At</th>
                    <th>Option</th>
                    </thead>
                    <tbody>
                    @foreach($admissions as $admission)
                        <tr>
                            <td>{{\Ignite\Reception\Entities\Patients::find($admission->patient_id)->first_name}}
                                {{\Ignite\Reception\Entities\Patients::find($admission->patient_id)->last_name}}
                            </td>
                            <td>{{\Ignite\Users\Entities\User::find($admission->doctor_id)->username}}</td>
                            <td>{{\Ignite\Evaluation\Entities\Ward::find($admission->ward_id)->name}}</td>
                            <td>{{\Ignite\Evaluation\Entities\Bed::find($admission->bed_id)->number}}</td>
                            <td>{{$admission->cost}}</td>
                            <td>{{$admission->created_at}}</td>
                            <td>
                                <a href="{{url('/evaluation/inpatient/manage/'.$admission->patient_id)}}" class="btn btn-primary">Manage</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>--}}
            @endif
        </div>
    </div>
    <script>
        $(function () {
            $("table").dataTable();
            $("button.addBed").click(function () {
                $("div.addBed").toggle();
            });

            $("button.checkOut").click(function () {
                var valu = this.value;
                $('#myModal').modal('show');

                $("#checkout").click(function () {
                    $('#myModal').modal('hide');
                    var SIGN_OUT = "{{url('/evaluation/inpatient/cancel_checkin')}}" +'/'+valu;
                    $.ajax({
//                        url:'/evaluation/inpatient/checkoutPatient'+'/'+valu
                        type: 'GET',
                        url: SIGN_OUT,

                    });
                    location.reload();
                })
            });



        });

    </script>

@endsection