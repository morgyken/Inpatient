<!-- Modal for controlling the payment type -->
            
<div id="authorize-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Patient Account</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'authorize-form']) !!}

                    <input id="admission-request-id" name="admission_request_id" type="hidden" value="" />
                    
                    <div class="form-group">
                        <label for="">Required Amount</label>
                        <input id="required-amount" type="text" class="form-control" disabled />
                    </div>

                    <div class="form-group">
                        <label for="">Enter Authorize Amount</label>
                        <input name="authorized" type="text" class="form-control" />
                    </div>

                {!! Form::close()!!}
            </div>
            <div class="modal-footer">
                <button id="authorize" type="button" class="btn btn-info">Authorize</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- @push('scripts') --}}
<script type="text/javascript">

var POST_AUTHORIZE_ENDPOINT = '/inpatient/admission-requests/update';

$(document).ready(function(){

    $('#authorize').click(function(){

        let data = $('#authorize-form').serialize();

        $.post(POST_AUTHORIZE_ENDPOINT, data, function(){
            
            $('#authorize').hide();

        }).done(function(){

            $('#authorize-modal').modal('hide');
            alertify.success("Authrorization successful");
            $('#authorize').show();
            $('#awaiting-admission').dataTable( ).api().ajax.reload();
            
        }).fail(function(){

            $('#authorize-modal').modal('hide');
            alertify.error("Something went wrong");
            $('#authorize').show();

        });

    });

})
</script>
{{-- @endpush --}}