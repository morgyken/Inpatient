@extends('layouts.app')
@section('content_title','Add admission type')
@section('content_description','Adding more admission types')

@section('content')

    @include('Inpatient::includes.success')

     @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Add/Edit admission type</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-horizontal">
                    {!! Form::open(['url'=>'/inpatient/admission-types']) !!}
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                                <label class="control-label col-md-4">Name</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        	<div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Description</label>
                                <div class="col-md-8">
                                     <textarea name="description" class="form-control" /></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div> 
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <br/>
                <div class="col-md-12">
                    @if($admissionTypes->count() > 0)
                     <table class="table table-responsive table-stripped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created On</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody> 
                           
                        </tbody>
                    </table>
                    @else
                    <br/>
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Hey!</strong> Seems there are no admission types added yet
                        </div>
                    @endif
                </div>
            </div>

            <div class="modal fade" id="editAdmissionTypeModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Edit Admission Type</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <form id="update_admission_type_form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="admission_type_id" id="admission_type_id" class="form-control" required>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                                            <label>Name</label>
                                            <input type="text" required name="name" id = "edit-name" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                            <label>Description</label>
                                            <textarea name="description" id = "edit-description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer"> 
                            <button type="button" class="btn btn-primary" id="update_admission_type">
                            	<i class="fa fa-save"></i> Update
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                            	<i class="fa fa-times"></i>Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('scripts') --}}
        <script type="text/javascript">
            $(function () {
                $(".table").dataTable({
                    ajax: "{{ url('/inpatient/admission-types/listing') }}",
                    reponsive: true
                });

                //edit ward
                $("body").on("click","button.edit", function (e) {
                    e.preventDefault();
                    $("#admission_type_id").val(this.id);
                    var url = '{{url('/inpatient/admission-types/edit')}}'+'/'+this.id;
                    $.ajax({
                        url:url
                    }).done(function (data) {
                    	console.log(data);

                        document.getElementById("update_admission_type_form").reset();
                        $("#edit-name").val(data.name);
                        $("#edit-description").val(data.description);
                        $("#update_admission_type").html("<i class='fa fa-save'></i> Update");
                        $("#editAdmissionTypeModal").modal();
                    })
                });

                $("#update_admission_type").click(function(e){
                    $(this).html("Saving...");
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/inpatient/admission-types/') }}/"+$("#admission_type_id").val()+"/update",
                        data: $("#update_admission_type_form").serialize()
                    }).done(function (data) {
                         document.getElementById("update_admission_type_form").reset();
                        $(this).html("<i class='fa fa-save'></i> Update");
                        $(".table").dataTable().api().ajax.reload();
                        $("#editAdmissionTypeModal").modal("toggle");
                    })
                });
            });
        </script>
    {{-- @endpush --}}

@endsection

