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
                                    <td>{{ $admission->patient->first_name }}
                                        {{ $admission->patient->last_name }}
                                    </td>
                                    @if(is_null($admission->doctor_id))
                                        <td>{{ $admission->external_doctor}}</td>
                                        @else
                                        <td>{{ $admission->doctor->profile->first_name }} {{ $admission->doctor->profile->last_name }}</td>
                                        @endif
                                    <td>{{ $admission->ward->name }}</td>
                                    <td>{{ $admission->bed->number }}</td>
                                    <td>{{ $admission->cost }}</td>
                                    <td>{{ $admission->created_at }}</td>
                                    <td>
                                       <a href="{{url('/inpatient/manage/'.$admission->patient->id.'/visit/'.$admission->visit_id)}}"
                                           class="btn btn-success btn-xs"> <i class="fa fa-ellipsis-h"></i> Manage</a>
                                        <a href="{{url('/inpatient/manage/'.$admission->patient->id.'/visit/'.$admission->visit_id.'/move')}}"
                                           class="btn btn-primary btn-xs"> <i class="fa fa-share"></i> Move</a>
                                        <a class="btn btn-warning btn-xs" href="{{url('/inpatient/manage/'.$admission->patient->id.'/requestDischarge/'.$admission->visit_id)}}">Request Discharge</a>   
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

            @endif
        </div>
    </div>
    <script>
        $(function () {
            $("table").dataTable();
            $("button.addBed").click(function () {
                $("div.addBed").toggle();
            });

            $("button.checkOut").click(function (e) {
                e.preventDefault();
                var valu = this.value;
                $('#myModal').modal('show');

                $("#checkout").click(function () {
                    $('#myModal').modal('hide');
                    var SIGN_OUT = "{{ url('/inpatient/admission/cancel/') }}" + valu;
                    $.ajax({
                        type: 'GET',
                        url: SIGN_OUT
                    });
                    location.reload();
                })
            });



        });

    </script>

@endsection