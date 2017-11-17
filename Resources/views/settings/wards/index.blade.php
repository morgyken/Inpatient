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
                    {!! Form::open(['url'=>'/inpatient/ward', 'autocomplete'=>'off']) !!}
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('number') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Ward Number</label>
                                <div class="col-md-8">
                                    <input type="text" name="number" class="form-control" value="{{ old('number') }}" />
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                                <label class="control-label col-md-4">Ward Name</label>
                                <div class="col-md-8">
                                     <input type="text" name="name" class="form-control" value="{{ old('name')}}" />
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Gender</label>
                                <div class="col-md-8">
                                    <select name="gender" class="form-control" required>
                                        <option value="male">Male</option>
                                        <option  value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Insurance Cost</label>
                                <div class="col-md-8">
                                     <input type="number" name="insurance_cost" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Cash Cost</label>
                                <div class="col-md-8">
                                     <input type="number" name="cash_cost" class="form-control" />
                                </div>
                            </div>
                            

                             <div class="form-group {{ $errors->has('age_group') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Age Group</label>
                                <div class="col-md-8">
                                    <select name="age_group" class="form-control">
                                        <option value="adult">Adult</option>
                                        <option value="children">Children</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pull-right">
                                <button class="btn btn-sm btn-primary">Save Ward</button>
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
                                <th>Insurance Cost</th>
                                <th>Cash Cost</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach($wards as $ward)
                                <tr>
                                    <td>{{ $ward->number }}</td>
                                    <td>{{ $ward->name }}</td>
                                    <td>{{ $ward->gender }}</td>
                                    <td>{{ $ward->age_group }}</td>
                                    <td>{{ $ward->insurance_cost }}</td>
                                    <td>{{ $ward->cash_cost }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs">Edit</button>
                                        <a href="{{ url('inpatient/ward/delete/'.$ward->id) }}" class="btn btn-danger btn-xs">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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
                                            <label>Insurance Cost</label>
                                            <input type="number" required name="cash_cost" id = "cash_cost" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
                                            <label>Cash Cost</label>
                                            <input type="number" required name="cash_cost" id = "cash_cost" class="form-control" />
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
            {{-- @push('scripts') --}}
                <script>
                    $(function () {
                        $("table").dataTable();
                    })
                </script>
            {{-- @endpush --}}
        </div>
    </div>

@endsection

