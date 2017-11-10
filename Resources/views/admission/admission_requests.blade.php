@extends('layouts.app')
@section('content_title','Patients Awaiting Admission')
@section('content_description','Patients Awaiting Admission')

@section('content')
    <div class="box box-info">
        <div class="box-body">
            @if(! count($admissionRequests))
                <div class="alert text-warning">
                    <span>The are no patients recorded</span>
                </div>

            @else

                <table class="table table-stripped table-condensed">
                    <caption>The Patient List: All The Patients awaiting admission</caption>
                    <thead>
                    <!-- <th>ID/Passport</th> -->
                    <th>Patient Name</th>
                    <th>Account Amount</th>
                    <th>Admission Type</th>
                    <th>Balance</th>
                    <th>Date</th>
                    <th>Options</th>
                    </thead>
                    <tbody>
                    @foreach($admissionRequests as $request)
                        <tr>
                            <td>{{ $request['patient']['name'] }}</td>
                            <td>{{ $request['patient']['account']['balance'] }}</td>
                            <td>
                                {{ $request['type']['name'] }}
                                ({{ number_format( $request['type']['deposit'] ) }})
                            </td>
                            <td>
                                {{ $request['due'] }}
                            </td>
                            <td>
                                {{ $request['created_at'] }}
                            </td>
                            <td>
                                <a class="btn btn-info btn-xs" href="{{ url('finance/patient/'.$request['patient']['id'].'/account') }}">
                                    Authorize
                                </a>
                                <button class="btn btn-success btn-xs deposit" 
                                        data-toggle="modal" data-target="#deposit-modal" value='{!! json_encode($request) !!}'>
                                    Payment Mode
                                </button>
                                <a class="btn btn-primary btn-xs" href="{{url('inpatient/admission/'.$request['id'].'/create')}}">
                                    Admit
                                </a>
                                <a class="btn btn-danger btn-xs" href="{{url('inpatient/admission/cancel/'.$request['patient']['id'])}}">Cancel</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

            @include('inpatient::admission.modals.admission_deposit_modal')

            {{-- @push('scripts') --}}
                <script>

                    $('.deposit').click(function(event){

                        let data = JSON.parse(event.target.value);

                        $('#patient-detail').val(data.patient.id);

                        hideTypeSelection(data.patient.schemes);

                    });

                    function hideTypeSelection(schemes)
                    {
                        schemes.length == 0 ? $('#hasInsurance').addClass('hidden') : null; 
                    }

                    $(function () {
                        $("table").dataTable();
                    })
                </script>
            {{-- @endpush --}}
        </div>
    </div>

@endsection
