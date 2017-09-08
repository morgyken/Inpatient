<div role="tabpanel" id="nurse" class="tab-pane fade in active col-md-12">

    <div class="container demo col-md-12">
        <br>
        <form id="nurse_notes" action="{{ url('/inpatient/manage/notes') }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $admission->visit_id }}" required>

            <div class="form-group">
                 <label>Write your notes here:</label>
                <textarea name="notes" id="notes" class="form-control" rows="10" placeholder="Nurses's Notes..." required autofocus></textarea>
            </div>
           
            <button type="button" class="btn btn-lg btn-primary" id = "save-note"><i class = "fa fa-save"></i> Save</button>
        </form>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
            <h3>Previous Notes</h3>

            <div class="alerts"></div>

            <div class="table-responsive">
                <table class="table table-stripped nurse-table" id = "nurses-table" style="width:100% !important; display: none !important;">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Note</th>
                            <th>Recorded By</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
            </div>
        </div>
        
    </div><!-- container -->

    <script type="text/javascript">
        $(function () {
            $(".nurse-table").dataTable();
        })

        getNotes();

        function getNotes(){
            $.ajax({
                type: "GET",
                url: "{{ url('/api/inpatient/v1/notes/admission/'.$admission->id.'/type/0') }}",
                dataType: 'json',
                success: function (resp) {                
                    if(resp.type === "success"){
                        if(resp.data.length > 0){
                            // refresh table
                            $("#nurses-table > tbody tr").remove();
                            // Loop through and append rows
                            let data = resp.data;
                            data.map( (item, index) => {
                                return(
                                    $("#nurses-table > tbody").append(
                                        "<tr id = 'row_"+ item.id +"'>\
                                            <td>" + item.written_on + "</td>\
                                            <td>" + item.notes + "</td>\
                                            <td>" + item.name + "</td>\
                                            <td><button type='button' class='btn btn-danger delete' id = '"+ item.id +"'><i class = 'fa fa-trash-o'></i> Delete</button></td>\
                                        </tr>"
                                    )
                                );
                            });

                            $("#nurses-table").css("display","block");
                           
                        }else{
                            $("#nurses-table").css("display","none");
                            alertify.error("No nurse's notes found for this patient");
                        }
                    }else{
                        alertify.error(resp.message);
                    }
                   
                },
                error: function (resp) {
                    alertify.error(resp.message);
                }
            });
        }

        $('#save-note').click(function(e){
            e.preventDefault();
             $.ajax({
                type: "POST",
                url: "{{ url('/api/inpatient/v1/notes') }}",
                data: JSON.stringify({
                     visit_id : {{ $admission->visit_id }},
                     admission_id: {{ $admission->id }},
                     notes: $("#notes").val(),
                     type: 1,
                     user: {{ Auth::user()->id }}
                 }),
                success: function (resp) {
                    // add table rows
                     if(resp.type === "success"){
                        alertify.success(resp.message);
                        getNotes();
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

        $('.delete').click(function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            $(this).html("Deleting ....");

             $.ajax({
                type: "POST",
                url: "{{ url('/api/inpatient/v1/notes/delete') }}",
                data: JSON.stringify({
                     id : id
                 }),
                success: function (resp) {
                    // add table rows
                     if(resp.type === "success"){
                        $("tr#row_"+id+"").remove();
                        alertify.success(resp.message);
                        $(this).html("<i class = 'fa fa-trash-o'></i> Delete");
                        // getNotes();
                    }else{
                         alertify.error(resp.message);
                    }
                },
                error: function (resp) {
                    $(this).html("<i class = 'fa fa-trash-o'></i> Delete");
                    alertify.error(resp.message);
                }
            });
        });

    
    </script>
  
</div>

