@extends('layouts.app')
@section('content_title','Patients Awaiting Discharge')
@section('content_description','Patients Awaiting Discharge')

@section('content')
    <div class="box box-info">
        <div class="box-body">
            @if(! count($dischargeRequests))
                <div class="alert text-warning">
                    <span>The are no patients recorded</span>
                </div>
            @else
                <table class="table table-stripped table-condensed" id="awaiting-discharge">
                    <caption>The Patient List: All The Patients awaiting discharge</caption>
                    <thead>
                        <th>Patient Name</th>
                        <th>Account Amount</th>
                        <th>Admission Type</th>
                        <th>Authorized Amount</th>
                        <th>Date</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        @foreach($dischargeRequests as $dischargeRequest)
                            <tr>
                                <td>{{ $dischargeRequest->visit->patients->fullName }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <script>
                $(document).ready(function(){
                    $('#awaiting-discharge').dataTable();
                });
            </script>
        </div>
    </div>
@endsection
