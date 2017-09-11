<div role="tabpanel" id="doctor" class="tab-pane fade in active col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <br>
        <form id="doctor_notes" action="{{ url('/inpatient/manage/notes') }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $admission->visit_id }}" required>

            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Write Notes</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-cam" id = "tabActivate" aria-controls="tab-cam" role="tab" data-toggle="tab">Take Picture of Notes</a>
                    </li>
                </ul>
            
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active col-md-12" id="home">
                        <div class="form-group">
                             <label>Write your notes here:</label>
                            <textarea name="notes" id="doctors-notes" class="form-control" rows="10" placeholder="Doctor's Notes..." required autofocus></textarea>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab-cam">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                       
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <br/>
                                <video id="video" style="border: 1px solid #333; width: 250px !important; height: 250px !important;" autoplay>Video stream not available.</video>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <br/>
                                <canvas id = "camera" style="border: 1px solid #333; width: 250px !important; height: 250px !important;"/>
                                
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <br/>
                                <button type="button" class="btn btn-default">Capture</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
           {{--  <div class="form-group">
                 <label>Write your notes here:</label>
                <textarea name="notes" id="doctors-notes" class="form-control" rows="10" placeholder="Doctor's Notes..." required autofocus></textarea>
            </div> --}}
           
            <button type="button" class="btn btn-lg btn-primary" id = "save-note"><i class = "fa fa-save"></i> Save</button>
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
                                    <button type='button' class='btn btn-success edit-note' id = '{{ $n->id }}'><i class = 'fa fa-pencil'></i> Edit</button>
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
                        <h4 class="modal-title">Notes By <span id = "doctor-info"></span></h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <textarea name="view-doctors-note" id="view-doctors-note" class="form-control" rows="3"  cols= "10" required></textarea>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id = "edit-view">Edit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                        <button type="button" class="btn btn-danger yes">Yes</button>
                        <button type="button" class="btn btn-success" id = "no"  data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        
    <script type="text/javascript">

        $(document).ready(function(){

            $("#tabActivate").click(function(){
                var camera = new JpegCamera("#camera");

                var snapshot = camera.capture();

                snapshot.show(); // Display the snapshot

                snapshot.upload({api_url: "/upload_image"}).done(function(response) {
                  response_container.innerHTML = response;
                  this.discard(); // discard snapshot and show video stream again
                }).fail(function(status_code, error_message, response) {
                  alert("Upload failed with status " + status_code);
                });
            
            });
            
            $("#doctors-table").dataTable();

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
                                            <button type='button' class='btn btn-success edit-note' id = '"+ item.id +"'><i class = 'fa fa-pencil'></i> Edit</button>\
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

            $('.view-note').click(function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    url: "{{ url('/api/inpatient/v1/notes') }}/"+id,
                    success: function (resp) {
                        if(resp.type === "success"){
                            alertify.success(resp.message);
                            console.log("Note: "+ resp.data)
                            $("#modal-view-doctor-note").modal();
                            $("#view-doctors-note").val(resp.data.notes);
                        }else{
                             alertify.error(resp);
                        }
                    },
                    error: function (resp) {
                        alertify.error(resp.message);
                    }
                });

            });            

            $('.delete-note').click(function(e){
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
