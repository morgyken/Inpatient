<!-- Administer drugs modal -->
<div id="administer-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Administer Drugs</h4>
            </div>
            <div class="modal-body" style="overflow: auto;">
                {!! Form::open(['id'=>'administer', 'url'=>'inpatient/administer-drugs', 'class' => 'form-horizontal']) !!}

                    @foreach($prescriptions as $prescription)

                        {!! Form::hidden("prescriptions[".$prescription['drug']."][prescription_id]", $prescription['id']) !!}

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-md-6">
                                    {!! Form::label($prescription['drug']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::text("prescriptions[".$prescription['drug']."][administered]", 0, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        
                    @endforeach

                {!! Form::close()!!}
            </div>
            <div class="modal-footer">
                <button id="record-drugs" type="button" class="btn btn-info">Record</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- End of administer dugs -->

<script>
$(document).ready(function(){
    $('body').on('click', '#record-drugs', function(){
        $('#administer').submit();
    });
});
</script>