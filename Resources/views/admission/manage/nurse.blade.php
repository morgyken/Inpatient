<div role="tabpanel" id="nurse" class="tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <br>
        <form id="nurse_notes">

            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $admission->visit_id }}" required>

            <div class="form-group">
                 <label>Write your notes here:</label>
                <textarea name="notes" id="nurses-notes" class="form-control summernote" rows="10" placeholder="Nurse's Notes..." required autofocus></textarea>
            </div>
           
            <button type="button" class="btn btn-lg btn-primary" id = "save-nurse-note"><i class = "fa fa-save"></i> Save</button>
        </form>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
            <h3>Previous Notes</h3>

            <div class="table-responsive">
                <table class="table table-stripped" id = "nurses-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Note</th>
                            <th>Recorded By</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($nursesNotes as $n)
                        <tr id = "nurse_noterow_{{ $n->id }}">
                            <td>{{ \Carbon\Carbon::parse($n->updated_at)->format('H:i A d/m/Y ') }}</td>
                            <td>{{ substr($n->notes,0,30) }}</td>
                            <td>{{ $n->users->profile->fullName }}</td>
                            <td>
                                <div class='btn-group'>
                                    <button class='btn btn-primary view-nurse-note' id = '{{ $n->id }}'><i class = 'fa fa-eye'></i> View</button>
                                    <button type='button' class='btn btn-danger delete-nurse-note' id = '{{ $n->id }}'><i class = 'fa fa-times' ></i> Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                      
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-view-nurse-note">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">View Notes</h4>
                    </div>
                    <div class="modal-body">
                         <form>
                            <input type="hidden" name="nurse_note_id" id = "nurse_note_id" required>
                            <textarea name="view-nurse-note" disabled="true" id="view-nurse-note" class="form-control summernote" rows="3"  cols= "10" required></textarea>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" id = "edit-nurse-note-view">Edit</button>
                            <button type="button" class="btn btn-primary" style="display: none;" id = "update-nurse-note">Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

         <div class="modal fade" id="modal-delete-nurse-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Are you sure you want to delete this note?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger yes-delete-nurse-note">Yes</button>
                        <button type="button" class="btn btn-success" id = "no-delete-nurse-note"  data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    <script type="text/javascript">

        $(document).ready(function(){
            
            $("#nurses-table").dataTable({
                "columnDefs": [ 
                    { 
                        "targets": [1], 
                        "type": "html", 
                        "render": function(data, type, row) { 
                            return $("<div/>").html(data).text();
                        } 
                    }
                ]
            });

            $('.summernote').summernote({
                height: 200
            });  

            $('#save-nurse-note').click(function(e){
                e.preventDefault();

                console.log("New nurse's note: "+ $("#notes").val());
                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/notes') }}",
                    data: JSON.stringify({
                         visit_id : {{ $admission->visit_id }},
                         admission_id: {{ $admission->id }},
                         notes: $("#nurses-notes").val(),
                         type: 0,
                         user: {{ Auth::user()->id }}
                     }),
                    success: function (resp) {
                        // add table rows
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            let data = JSON.parse(resp.data);
                            console.log(data);
                            data.map( (item, index) => {
                                return(
                                    $("#nurses-table > tbody").append("<tr id = 'nurse_noterow_"+ item.id +"'>\
                                        <td>" + item.written_on + "</td>\
                                        <td>" + item.notes + "</td>\
                                        <td>" + item.name + "</td>\
                                        <td><div class='btn-group'>\
                                         <button type='button' class='btn btn-primary view-nurse-note' id = '"+ item.id + "'><i class = 'fa fa-eye' ></i> View</button>\
                                            <button type='button' class='btn btn-danger delete-nurse-note' id = '"+ item.id + "'><i class = 'fa fa-times' ></i> Delete</button>\
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

            $('body').on('click','.view-nurse-note', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $("#nurse_note_id").val(id);

                $.ajax({
                    type: "GET",
                    url: "{{ url('/api/inpatient/v1/notes') }}/"+id,
                    success: function (resp) {
                        if(resp.type === "success"){                      
                            resp.data.map( (item, index) => {
                                return(
                                    $("#view-nurse-note").text(item.notes)
                                );
                            });

                            $("#view-nurse-note").prop('disabled', true);
                            $("#edit-nurse-note-view").css("display","block");
                            $("#update-nurse-note").css("display","none");

                            $("#modal-view-nurse-note").modal();
                        }else{
                             alertify.error(resp.data);
                        }
                    },
                    error: function (resp) {
                        alertify.error(resp.message);
                    }
                });
            });

            $('body').on('click','#edit-nurse-note-view', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $("#view-nurse-note").prop('disabled', false);
                $("#update-nurse-note").css("display","block");
                $(this).css("display","none");
            });   

            $('#update-nurse-note').click(function(e){
                var id = $("#nurse_note_id").val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/notes/update') }}",
                    data: JSON.stringify({
                         id : id,
                         notes: $("#view-nurse-note").val(),
                         user: {{ Auth::user()->id }}
                     }),
                    success: function (resp) {
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#modal-view-nurse-note").modal('toggle');
                            // update 
                        }else{
                             alertify.error(resp.message);
                        }
                    },
                    error: function (resp) {
                        alertify.error(resp.message);
                    }
                });
            }); 


            $('body').on('click', '.delete-nurse-note', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $(".yes-delete-nurse-note").attr('id', id); 
                $("#modal-delete-nurse-id").modal();
            });


            $('.yes-delete-nurse-note').click(function(e){
                var id = $(this).attr('id');
                 $.ajax({
                    type: "POST",
                    url: "{{ url('/api/inpatient/v1/notes/delete') }}",
                    data: JSON.stringify({ id : id }),
                    success: function (resp) {
                         if(resp.type === "success"){
                            alertify.success(resp.message);
                            $("#modal-delete-nurse-id").modal('toggle');
                            $("#nurse_noterow_"+id+"").remove();
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

