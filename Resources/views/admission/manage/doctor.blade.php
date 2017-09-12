<div role="tabpanel" id="doctor" class="tab-pane fade in active col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <br>
        <form id="doctor_notes" action="{{ url('/inpatient/manage/notes') }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $admission->visit_id }}" required>

            <div class="form-group">
                <label>Write your notes here:</label>
                <textarea name="notes" id="doctors-notes" class="form-control" rows="10" placeholder="Doctor's Notes..." required autofocus></textarea>
            </div>
            
            <br/>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                <br/>
                <button type="button" class="btn btn-lg btn-primary" id = "save-note"><i class = "fa fa-save"></i> Save</button>&nbsp;
                <button type="button" class="btn btn-lg btn-default" id = "open-capture-modal"><i class = "fa fa-camera"></i> Capture</button>
            </div>
            
        </form>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
            <h3>Previous Notes</h3>

            <div class="alerts"></div>

            <div class="table-responsive">
                <table class="table table-stripped" id = "doctors-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Note</th>
                            <th>Recorded By</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($doctorsNotes as $n)
                        <tr id = "noterow_{{ $n->id }}">
                            <td>{{ \Carbon\Carbon::parse($n->updated_at)->format('H:i A d/m/Y ') }}</td>
                            <td>{{ substr($n->notes,0,30) }}</td>
                            <td>{{ $n->users->profile->fullName }}</td>
                            <td>
                                <div class='btn-group'>
                                    <button class='btn btn-primary view-note' id = '{{ $n->id }}'><i class = 'fa fa-eye'></i> View</button>
                                    <button type='button' class='btn btn-danger delete-note' id = '{{ $n->id }}'><i class = 'fa fa-times' ></i> Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                      
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-view-doctor-note">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">View Notes</small></h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" name="note_id" id = "note_id" required>
                            <textarea name="view-doctors-note" disabled="true" id="view-doctors-note" class="form-control" rows="3"  cols= "10" required></textarea>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" id = "edit-note-view"><i class = "fa fa-pencil"></i> Edit</button>
                            <button type="button" class="btn btn-primary" style="display: none;" id = "update-doctor-note">Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Are you sure you want to delete this note?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger yes"><i class = "fa fa-thumbs-up"></i> Yes</button>
                        <button type="button" class="btn btn-success" id = "no"  data-dismiss="modal"><i class = "fa fa-thumbs-down"></i> No</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-capture">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Take a photo of your Notes</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  style="padding: 0 !important;">                       
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"  style="padding: 0 !important;">
                                <br/>
                                <div id="camera-wrapper">
                                    <div class="camera" id="camera" style="border: 1px solid blue; width: 250px !important; height: 250px !important;"></div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <br/>
                                <canvas id = "camera2" style="border: 1px solid #333; width: 250px !important; height: 250px !important;"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><br/>
                        <button type="button" class="btn btn-primary" ><i class="fa fa-camera"></i> Capture</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
    <script type="text/javascript">

        $(document).ready(function(){
            
            $("#doctors-table").dataTable();

            var initCamera = function () {
              if (!window.JpegCamera) {
                alert('Camera access is not available in your browser');
              } else {
                camera = new JpegCamera('#camera')
                  .ready(function (resolution) {})
                  .error(function () {
                  alert('Camera access was denied');
                });
              }
            };

            var bindEvents = function () {
              $('#camera-wrapper').on('click', '#shoot', capture);
              $('#layout-options').on('click', 'canvas', download);
            };

            var init =  function () {
              initCamera();
              bindEvents();
            }

            $("#open-capture-modal").click(function(e){
                e.preventDefault();
                $("#modal-capture").modal();
                init();
            });
            
            $("#tabActivate").click(function(){
                var camera = new JpegCamera("#camera");

                var snapshot = camera.capture();

                snapshot.show(); // Display the snapshot

                snapshot.upload({api_url: "/upload_image"}).done(function(response) {
                  // response_container.innerHTML = response;
                  this.discard(); // discard snapshot and show video stream again
                }).fail(function(status_code, error_message, response) {
                  alert("Upload failed with status " + status_code);
                });
            
            });
            
            

            $('#save-note').click(function(e){
                e.preventDefault();
                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/notes') }}",
                    data: JSON.stringify({
                         visit_id : {{ $admission->visit_id }},
                         admission_id: {{ $admission->id }},
                         notes: $("#doctors-notes").val(),
                         type: 1,
                         user: {{ Auth::user()->id }}
                     }),
                    success: function (resp) {
                        // add table rows
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            let data = JSON.parse(resp.data);
                            data.map( (item, index) => {
                                return(
                                    $("#doctors-table > tbody").append("<tr id = 'noterow_"+ item.id +"'>\
                                        <td>" + item.written_on + "</td>\
                                        <td>" + item.notes + "</td>\
                                        <td>" + item.name + "</td>\
                                        <td><div class='btn-group'>\
                                            <button class='btn btn-primary view-note' id = '"+ item.id +"'><i class = 'fa fa-eye'></i> View</button>\
                                             <button type='button' class='btn btn-danger delete-note' id = '"+ item.id + "'><i class = 'fa fa-times' ></i> Delete</button>\
                                         </div></td></tr>")
                                );
                            });
                        }else{
                             alertify.error(resp.message);
                        }
                    },
                    error: function (resp) {
                        console.log(resp);
                         alertify.error(resp.message);
                    }
                });
            });

            $('body').on('click','.view-note', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $("#note_id").val(id);

                $.ajax({
                    type: "GET",
                    url: "{{ url('/api/inpatient/v1/notes') }}/"+id,
                    success: function (resp) {
                        if(resp.type === "success"){                      
                            resp.data.map( (item, index) => {
                                return(
                                    $("#view-doctors-note").val(item.notes)
                                );
                            });

                            $("#view-doctors-note").prop('disabled', true);
                            $("#edit-note-view").css("display","block");
                            $("#update-doctor-note").css("display","none");

                            $("#modal-view-doctor-note").modal();
                        }else{
                             alertify.error(resp.data);
                        }
                    },
                    error: function (resp) {
                        alertify.error(resp.message);
                    }
                });
            });

            $('body').on('click','#edit-note-view', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $("#view-doctors-note").prop('disabled', false);
                $("#update-doctor-note").css("display","block");
                $(this).css("display","none");
            });   

            $('#update-doctor-note').click(function(e){
                var id = $("#note_id").val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/notes/update') }}",
                    data: JSON.stringify({
                         id : $("#note_id").val(),
                         notes: $("#view-doctors-note").val(),
                         user: {{ Auth::user()->id }}
                     }),
                    success: function (resp) {
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#modal-view-doctor-note").modal('toggle');
                            // $("#noterow_"+id+"").remove();
                        }else{
                             alertify.error(resp.message);
                        }
                    },
                    error: function (resp) {
                        alertify.error(resp.message);
                    }
                });
            });         

            $('body').on('click','.delete-note', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $(".yes").attr('id', id); 
                $("#modal-delete-id").modal();
            });

            $('.yes').click(function(e){
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/notes/delete') }}",
                    data: JSON.stringify({
                         id : id
                     }),
                    success: function (resp) {
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#modal-delete-id").modal('toggle');
                            $("#noterow_"+id+"").remove();
                        }else{
                             alertify.error(resp.message);
                        }
                    },
                    error: function (resp) {
                        alertify.error(resp.message);
                    }
                });
            });

        });

    
    </script>
  
</div>
