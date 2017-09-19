@extends('layouts.app')
@section('content_title','Add ward')
@section('content_description','Adding more wards')

@section('content')
    @include('Evaluation::inpatient.success')

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Add/Edit category</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-horizontal">
                    {!! Form::open(['url'=>'/evaluation/inpatient/addwordFormPost']) !!}
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
                                <select name="gender" class="form-control">
                                        
                                        <option value="male">Male</option>
                                        <option  value="female">Female</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>
                            </div>

                             <div class="form-group {{ $errors->has('age_group') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Age Group</label>
                                <div class="col-md-8">
                                <select name="age_group" class="form-control">
                                        
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
                <div class="col-md-12">
                    @if($wards->count() > 0)
                     <table class="table table-responsive table-striped">
                        <tbody> 
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Gender</th>
                                    <th>Cost</th>
                                    <th>Created On</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                        @foreach($wards as $ward)
                            <tr>
                            <td>{{$ward->number}}</td>
                                <td>{{$ward->name}}</td>
                                <td>{{$ward->category}}</td>
                                <td>{{ $ward->gender }}</td>
                                <td>Ksh.{{$ward->cost}}</td>
                                <td>{{$ward->created_at}}</td>
                                <td>
                                    <a href="{{url('/evaluation/inpatient/delete_ward'.'/'.$ward->id)}}" class="btn btn-danger btn-xs">Delete</a>
                                    <button class="btn btn-primary btn-xs edit" id="{{$ward->id}}" data-toggle="modal" data-target="#myModal" >Edit</button>
                                </td>
                            </tr>
                        @endforeach()   
                        </tbody>
                    </table>
                    @else
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Hey!</strong> Seems there are no wards added yet
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $(".table").dataTable();

                //edit ward
                $("button.edit").click(function () {
                    // AAX FETCH RECOrd
                    $("#wardId").val(this.id);
                    var url = '{{url('/evaluation/inpatient/editWard')}}'+'/'+this.id;
                    $.ajax({
                        url:url
                    }).done(function (data) {
                        console.info(data);
                        //attach data returned...
                        $("#name").val(data.name);
                        $("#category").val(data.category);
                    })
                })
            });
        </script>
    @endpush

@endsection

