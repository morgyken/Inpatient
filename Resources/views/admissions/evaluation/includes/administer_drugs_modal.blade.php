<!-- Administer drugs modal -->
<div id="administer-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Administer Drugs</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'inpatient/administer-drugs']) !!}

                        @foreach($prescriptions as $prescription)

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        {!! Form::label($prescription['drug']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::text() !!}
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach

                    {!! Form::close()!!}
                </div>
                <div class="modal-footer">
                    <button id="authorize" type="button" class="btn btn-info">Authorize</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of administer dugs -->