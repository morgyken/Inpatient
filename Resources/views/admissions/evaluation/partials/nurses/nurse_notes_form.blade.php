<div class="panel panel-info" id="form">
    <div class="panel-heading">
        <h5>Nurses Notes Form</h5>
    </div>

    <div class="panel-body">
        <form id="nurse_notes">
            {{ csrf_field() }}

            <input type="hidden" name="admission_id" id="admission_id" value="{{ $admission->id }}" required>

            <input type="hidden" name="visit_id" id = "visit_id" value="{{ $visit->id }}" required>

            <div class="form-group">
                    <label>Write your notes here:</label>
                <textarea name="notes" id="nurses-notes" class="form-control summernote" rows="10" placeholder="Nurse's Notes..." required autofocus></textarea>
            </div>
            
            <button type="button" class="btn btn-primary col-md-1" id = "save-nurse-note">Save</button>
        </form>
    </div>

    <!-- Start Scripts -->
    {{-- @push('scripts') --}}
    <script>
        $('.summernote').summernote({
            height: 200
        });  

        $('#save-nurse-note').click(function(e){
            e.preventDefault();
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
    </script>
    {{-- @endpush --}}
    <!-- End Scripts -->    
</div>