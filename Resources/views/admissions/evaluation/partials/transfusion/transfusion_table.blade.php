<div class="panel panel-info">
    <div class="panel-heading">
        Previous Blood Tranfusion Data
    </div>
    <div class="panel-body">
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
            @foreach($transfusions as $transfusion)
                <tr id = "transfusion_row_{{ $transfusion->id }}">
                    <td>{{ \Carbon\Carbon::parse($transfusion->created_at)->toDateTimeString() }}</td>
                    <td>{{ $transfusion->temperature }} <sup>o</sup>C</td>
                    <td>{{ $transfusion->bp_systolic }} / {{ $transfusion->bp_diastolic }}</td>
                    <td>{{ $transfusion->respiration }}</td>
                    <td>{{ (strlen($transfusion->remarks) > 0) ? substr($transfusion->remarks, 0, 20) : 'None' }}</td>
                    <td>{{ $transfusion->user->profile->fullName }}</td>
                    <td>
                        <div class='btn-group'>
                            {{--  <button class='btn btn-primary view-transfusion' id = '{{ $transfusion->id }}'><i class = 'fa fa-eye'></i> View</button>
                            <button type='button' class='btn btn-success edit-transfusion' id = '{{ $transfusion->id }}'><i class = 'fa fa-pencil'></i> Edit</button> 
                            <button type='button' class='btn btn-danger btn-sm delete-transfusion' id = '{{ $transfusion->id }}'><i class = 'fa fa-times' ></i> Delete</button>--}}
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