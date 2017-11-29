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
                <table class="table table-stripped table-condensed" id="awaiting-admission">
                    <caption>The Patient List: All The Patients awaiting admission</caption>
                    <thead>
                        <th>Patient Name</th>
                        <th>Account Amount</th>
                        <th>Admission Type</th>
                        <th>Authorized Amount</th>
                        <th>Date</th>
                        <th>Options</th>
                    </thead>
                    <tbody></tbody>
                </table>
            @endif

            @include('Inpatient::admission.modals.authorization_modal')

            @include('Inpatient::admission.modals.admission_deposit_modal')

            @include('Inpatient::admission.modals.print_slip_modal')


            <script>
                var ADMISSION_REQUEST_ENDPOINT = "/inpatient/admission-requests";

                $(document).ready(function(){

                    $('#awaiting-admission').dataTable({
                        'ajax': {
                            'url': ADMISSION_REQUEST_ENDPOINT,
                        },
                    });

                    $('body').on('click', '.deposit', function(event){

                        let data = JSON.parse(event.target.value);

                        $('#admission-letter-print').attr('href', '/inpatient/admission-letter/create/' + data.patient.id);

                        $('#patient-detail').val(data.patient.id);

                        $('#admit-request-id').val(data.id);

                        let schemes = data.patient.schemes;

                        addPatientSchemes(schemes);

                        data.patient.schemes.length == 0 ? $('#hasInsurance').addClass('hidden') : 
                                                            $('#hasInsurance').removeClass('hidden'); 

                    });

                    $('body').on('click', '.authorize', function(event){

                        let data = JSON.parse(event.target.value);

                        $('#admission-request-id').val(data.id);

                        var requiredAmount = data.type.name + " - " + data.type.deposit;

                        $('#required-amount').val(requiredAmount);
                    })

                    function addPatientSchemes(schemes)
                    {
                        $('#insurance-scheme').empty();

                        for(var item = 0; item < schemes.length; item++)
                        {
                            var value = schemes[item]['id'];
                            var text = schemes[item]['name'];

                            $('#insurance-scheme').append($('<option>', {
                                value: value,
                                text: text
                            }));
                        }
                    }
                });
                
            </script>
        </div>
    </div>

@endsection
