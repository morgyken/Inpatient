@extends('layouts.app')
@section('content_title','Add ward')
@section('content_description','Adding more wards')

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
            <h3 class="box-title">Add/Edit category</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-horizontal">
                    {!! Form::open(['url'=>'/inpatient/ward/add']) !!}
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('number') ? ' has-error' : '' }} req">
                                <label class="control-label col-md-4">Ward Number</label>
                                <div class="col-md-8">
                                    <input type="text" required name="number" class="form-control" />
                                    
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                                <label class="control-label col-md-4">Ward Name</label>
                                <div class="col-md-8">
                                     <input required  type="text" name="name" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Ward Cost</label>
                                <div class="col-md-8">
                                     <input type="number"  required name="cost" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Gender</label>
                                <div class="col-md-8">
                                <select name="gender" class="form-control" required>
                                        
                                        <option value="male">Male</option>
                                        <option  value="female">Female</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>
                            </div>

                             <div class="form-group {{ $errors->has('age_group') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Age Group</label>
                                <div class="col-md-8">
                                <select name="age_group" class="form-control" required>
                                        
                                        <option value="Adult">Adult</option>
                                        
                                        <option  value="Children">Children</option>
                                    </select>
                                </div>
                            </div>

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
                    @if($wards->count() > 0)
                     <table class="table table-responsive table-stripped table-hover">
                        <thead>
                            <tr>
                                <th>Ward Number</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age Group</th>
                                <th>Cost</th>
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
                            <strong>Hey!</strong> Seems there are no wards added yet
                        </div>
                    @endif
                </div>
            </div>

            <div class="modal fade" id="editWardModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Edit Ward</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <form id = "update_ward_form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="ward_id" id="ward_id" class="form-control" required>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group {{ $errors->has('number') ? ' has-error' : '' }} req">
                                            <label>Ward Number</label>
                                            <input type="text" required name="number" id = "number" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                                            <label>Ward Name</label>
                                            <input required type="text" name="name" id = "name" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
                                            <label>Ward Cost</label>
                                            <input type="number" required name="cost" id = "cost" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control" id = "gender" required>
                                                <option value="male">Male</option>
                                                <option  value="female">Female</option>
                                                <option value="both">Both</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                         <div class="form-group {{ $errors->has('age_group') ? ' has-error' : '' }}">
                                            <label>Age Group</label>
                                            <select name="age_group" class="form-control" id = "age_group" required>
                                                <option value="Adult">Adult</option>
                                                <option  value="Children">Children</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer"> 
                            <button type="button" class="btn btn-primary" id = "update_ward"><i class="fa fa-save"></i> Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                           
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
                    ajax: "{{ url('/inpatient/ward/all') }}",
                    reponsive: true
                });

                //edit ward
                $("body").on("click","button.edit", function (e) {
                    e.preventDefault();
                    // AAX FETCH RECOrd
                    $("#wardId").val(this.id);
                    $("#ward_id").val(this.id);
                    var url = '{{url('/inpatient/ward/editWard')}}'+'/'+this.id;
                    $.ajax({
                        url:url
                    }).done(function (data) {
                        document.getElementById("update_ward_form").reset();
                        $("#number").val(data.number);
                        $("#name").val(data.name);
                        $("#cost").val(data.cost);
                        $("#update_ward").html("<i class='fa fa-save'></i> Update");
                        $("#editWardModal").modal();
                    })
                });

                $("#update_ward").click(function(e){
                    $(this).html("Saving...");
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/inpatient/ward/') }}/"+$("#ward_id").val()+"/update",
                        data: $("#update_ward_form").serialize()
                    }).done(function (data) {
                         document.getElementById("update_ward_form").reset();
                        $(this).html("<i class='fa fa-save'></i> Update");
                        $(".table").dataTable().api().ajax.reload();
                        $("#editWardModal").modal("toggle");
                    })
                });
            });
        </script>
    {{-- @endpush --}}

@endsection

