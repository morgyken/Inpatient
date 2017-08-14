@extends('layouts.app')
@section('content_title','Admissions Requests')
@section('content_description','Requests sent for patient admission')

@section('content')

    <div class="">
        <div class="">
            @if(! count($patient_awaiting))
                <div class="box box-info">
                    <div class="box-body">
                        <span class="text-warning">The are no admission request</span>
                    </div>
                </div>

            @else
                <div class="box box-info">
                    <div class="box-body">

                        <table class="table table-stripped table-condensed">
                            <thead>
                            <th>Name.</th>
                            <th>External Doc.</th>
                            <th>Payment Mode</th>
                            <th>Date</th>
                            <th>Option</th>
                            </thead>
                            <tbody>
                            @foreach($patient_awaiting as $admission)
                                <tr>
                                    <td>{{\Ignite\Reception\Entities\Patients::find($admission->patient)->full_name}}
                                    </td>
                                    <td>{{$admission->external_doctor}}</td>
                                    <td>{{$admission->payment_mode}}</td>
                                    <td>{{(new Date($admission->created_at))->format('m/d/y')}}</td>
                                    <td>
                                        <a href="{{url('/evaluation/inpatient/admit/'.$admission->patient.'/'.$admission->id)}}" class="btn btn-primary btn-xs" >Admit</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

{{--                <table class="table table-stripped condensed">
                    <caption>The Beds List: All The Beds</caption>
                    <thead>
                    <th>Name.</th>
                    <th>External Doc.</th>
                    <th>Payment Mode</th>
                    <th>Date</th>
                    <th>Option</th>
                    </thead>
                    <tbody>
                    @foreach($patient_awaiting as $admission)
                        <tr>
                            <td>{{\Ignite\Reception\Entities\Patients::find($admission->patient)->first_name}}
                                {{\Ignite\Reception\Entities\Patients::find($admission->patient)->last_name}}
                            </td>
                            <td>{{$admission->external_doctor}}</td>
                            <td>{{$admission->payment_mode}}</td>
                            <td>{{$admission->created_at}}</td>
                            <td>
                                <a href="{{url('/evaluation/inpatient/admit/'.$admission->patient)}}" class="btn btn-primary btn-small" >Admit</a></td>
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
            })
        });

    </script>

@endsection