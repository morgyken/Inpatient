<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
            <h3>Previous Blood Transfusion Data</h3>

            <div class="alerts"></div>

            <div class="table-responsive">
                <table class="table table-stripped" id = "transfusion-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Temp.</th>
                            <th>BP</th>
                            <th>Resp. Rate</th>
                            <th>Remarks</th>
                            <th>Recorded By</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($transfusions as $t)
                        <tr id = "transfusion_row_{{ $t->id }}">
                            <td>{{ $t->date_recorded }} {{ $t->time_recorded }}</td>
                            <td>{{ $t->temperature }} <sup>o</sup>C</td>
                            <td>{{ $t->bp_systolic }} / {{ $t->bp_diastolic }}</td>
                            <td>{{ $t->respiration }}</td>
                            <td>{{ (strlen($t->remarks) > 0) ? substr($t->remarks, 0, 20) : 'None' }}</td>
                            <td>{{ $t->user->profile->fullName }}</td>
                            <td>
                                <div class='btn-group'>
                                   {{--  <button class='btn btn-primary view-transfusion' id = '{{ $t->id }}'><i class = 'fa fa-eye'></i> View</button>
                                    <button type='button' class='btn btn-success edit-transfusion' id = '{{ $t->id }}'><i class = 'fa fa-pencil'></i> Edit</button> --}}
                                    <button type='button' class='btn btn-danger delete-transfusion' id = '{{ $t->id }}'><i class = 'fa fa-times' ></i> Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                      
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-view-doctor-transfusion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Recorded By <span id = "doctor-info"></span></h4>
                    </div>
                    <div class="modal-body">
                        <form>
                          
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id = "edit-blood-view">Edit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete-transfusion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Are you sure you want to delete this note?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger yes-delete-transfusion">Yes</button>
                        <button type="button" class="btn btn-success" id = "no-delete-transfusion"  data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>