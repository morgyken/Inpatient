<!-- Modal for controlling the payment type -->
<div id="deposit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Patient Account</h4>
            </div>
            <div class="modal-body">
                <!-- Payments Selection -->
                <div id="hasInsurance" >
                    <div class="form-group" class="row">
                        <div class="col-md-6">
                            <input id="cash-type" class="changeType" name="payment_type" value="cash_payment" type="radio" checked />
                            <label for="cash-type">Cash Deposit</label>
                        </div>
                        <div class="col-md-6">
                            <input id="insurance" class="changeType" name="payment_type" value="insurance" type="radio" />
                            <label for="insurance">Insurance Cover</label>
                        </div>
                    </div>
                    <hr>
                </div>

                {!! Form::open(['id'=>'payment-details-form', 'autocomplete'=>'off', 'files' => true])!!}

                    <input id="patient-detail" name="patient" type="hidden" value="" />

                    <div id="cash-display">
                        <div class="panel-group" id="payment-method">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#payment-method" href="#cash">
                                        <b class="text-info">Cash</b></a>
                                    </h4>
                                </div>
                                <div id="cash" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="form-group col-md-12">
                                            <label>Cash Amount</label>
                                            {!! Form::text('cash[amount]', null, ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#payment-method" href="#mpesa">
                                        <b class="text-info">Mpesa</b></a>
                                    </h4>
                                </div>
                                <div id="mpesa" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group col-md-6">
                                            <label>Mpesa Code</label>
                                            {!! Form::text('mpesa[reference]', null, ['class'=>'form-control']) !!}
                                        </div>
        
                                        <div class="form-group col-md-6">
                                            <label>Mpesa Amount</label>
                                            {!! Form::text('mpesa[amount]', null, ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#payment-method" href="#cheque">
                                        <b class="text-info">Cheque</b></a>
                                    </h4>
                                </div>
                                <div id="cheque" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group col-md-6">
                                            <label>Drawer:</label>
                                            {!! Form::text('cheque[name]', null, ['class'=>'form-control']) !!}
                                        </div>
            
                                        <div class="form-group col-md-6">
                                            <label>Bank:</label>
                                            {!! Form::text('cheque[bank]', null,['class'=>'form-control']) !!}
                                        </div>
            
                                        <div class="form-group col-md-6">
                                            <label>Amount:</label>
                                            {!! Form::text('cheque[amount]', null, ['class'=>'form-control']) !!}
                                        </div>
            
                                        <div class="form-group col-md-6">
                                            <label>Cheque Number:</label>
                                            {!! Form::text('cheque[number]', null, ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#payment-method" href="#card">
                                        <b class="text-info">Card</b></a>
                                    </h4>
                                </div>
                                <div id="card" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group col-md-6">
                                            <label>Name:</label>
                                            {!! Form::text('card[name]', null, ['class'=>'form-control']) !!}
                                        </div>
            
                                        <div class="form-group col-md-6">
                                            <label>Card Number:</label>
                                            {!! Form::text('card[number]', null, ['class'=>'form-control']) !!}
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Expiry Date:</label>
                                            {!! Form::text('card[expiry]', null, ['placeholder'=>'eg. 04/22','class'=>'form-control']) !!}
                                        </div>
            
                                        <div class="form-group col-md-6">
                                            <label>Amount:</label>
                                            {!! Form::text('card[amount]', null, ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="insurance-display" class="hidden">
                        <input id="admit-request-id" type="hidden" name="insurance[admission_request_id]" />

                        <div class="form-group col-md-12">
                            <label>Insurance Scheme</label>
                            <select name="insurance[scheme_id]" id="insurance-scheme" class="form-control"></select>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Maximum Amount Allowed By Insurance</label>
                            <input type="number" class="form-control" name="insurance[maximum_amount]" />
                        </div>
                    </div>
                {!! Form::close()!!}
            </div>
            <div class="modal-footer">
                <button id="save-account-details" type="button" class="btn btn-success">Save Details</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ m_asset('inpatient:css/admissions.css') }}">

{{-- @push('scripts') --}}
<script type="text/javascript">

    $('.changeType').click(function(event){
        
        var payment = event.target.value

        if(payment == 'cash_payment')
        {
            $('#cash-display').removeClass('hidden');

            $('#insurance-display').addClass('hidden');
        }

        if(payment == 'insurance')
        {
            $('#cash-display').addClass('hidden');

            $('#insurance-display').removeClass('hidden');
        }

    });

    /*
    * Submit the details form using ajax
    */
    $('#save-account-details').click(function(){

        $('#save-account-details').hide();

        var POST_PATIENT_ACCOUNT_ENDPOINT = "/finance/patient/" + $('#patient-detail').val() + "/account/deposit";

        let data = $('#payment-details-form').serialize();

        $.post(POST_PATIENT_ACCOUNT_ENDPOINT, data, function(){

        }).done(function(){

            alertify.success("Success!");
            $('#save-account-details').show();
            $('#deposit-modal').modal('hide');
            $('#awaiting-admission').dataTable( ).api().ajax.reload();

        }).fail(function(){

            alertify.error("Something went wrong");
            $('#save-account-details').show();
            $('#deposit-modal').modal('hide');

        });
    });
</script>
{{-- @endpush --}}