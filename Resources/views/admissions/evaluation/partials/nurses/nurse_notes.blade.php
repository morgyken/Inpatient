<div class="panel panel-info">
    <div class="panel-heading">
        <h5>Previous Nurse Notes</h5>
    </div>

    <div class="panel-body items-container">
        <div class="accordion">
            @foreach($notes as $note)
                <h4>
                    <span>{{ $note['title'] }}</span>
                    <span class="pull-right">{{ $note['date'] }}</span>
                </h4>
                <div>
                    {{ $note['body'] }}

                    <div style="margin-top: 5px">
                        <button class="edit-note" value="{{ $note['id']  }}" data-toggle="modal" data-target="#edit" class="btn btn-info btn-xs">Edit Note</button>
                    </div>
                </div>
            @endforeach    
        </div>

        {{-- Modal Start --}}
        <div id="edit" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Nurses's Note</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['url' => "inpatient/evaluations/$visit->id/nurse/update" ]) !!}
                        <input name="noteId" type="hidden" id="note-id" />

                        <div class="form-group">
                            {!! Form::label('title', 'Note Title') !!}
                            {!! Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'placeholder' => 'Note Title ...']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('notes', 'Write Doctors Notes') !!}
                            {!! Form::textarea('notes', null, ['id' => 'notes', 'class' => 'form-control summernote', 'rows' => '10', 'placeholder' => 'Doctors Notes ...']) !!}
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
                            <button type="submit" class="btn btn-primary col-md-3" id="save-note">Update Note</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>

            </div>
        </div>
        {{-- Modal End --}}
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.accordion').accordion({heightStyle: "content"});

        $('body').on('click', '.edit-note', function(event){

            $('#note-id').val(event.target.value);

        });
    })
</script>