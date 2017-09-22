@extends('layouts.app')
@section('content_title','Admit Bed Position')
@section('content_description','Action to bed position')

@section('content')
    @include('Inpatient::includes.success')

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add/Edit category</h3>
            </div>
            <div class="box-body">

        
            <div class="row">
                <div class="form-horizontal">
                    {!! Form::open(['url'=>'/inpatient/beds/position']) !!}
                    <div class="col-md-12">
                        <div class="col-md-6">
                          <div class="form-group {{ $errors->has('ward') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Ward</label>
                                <div class="col-md-8">
                                <select name="ward_id" class="form-control">
                                        @foreach($wards as $ward)
                                            <option value="{{$ward->id}}">{{$ward->name}} / {{$ward->number}}</option>
                                        @endforeach()
                                    </select>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                                <label class="control-label col-md-4">bed Position</label>
                                <div class="col-md-8">
                                     <input required  type="text" name="name" class="form-control" />
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
                @foreach($wards as $w)
                <h3 class="text-center"> {{$w->name}} Ward</h3>
                <div class="col-md-12">
                   
                    <table class="table table-responsive table-striped"> 
                        <thead>
                            <tr>
                                <th>Bed Position</th>
                                <th>Ward Gender</th>
                                <th>Added On</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($w->bedpositions as $bedp)

                                <tr>
                                    <td>{{$bedp->name}} </td>
                                    <td>{{$bedp->ward->gender}} ward</td>
                                    <td>{{($bedp->created_at)->format('d/M/y g:i a')}}</td>
                                    <td>
                                        <a href="{{url('/inpatient/beds/position'.'/'.$bedp->id)}}" class="btn btn-danger btn-xs">Delete</a>
                                        <button class="btn btn-primary btn-xs edit" id="{{$bedp->id}}" data-toggle="modal" data-target="#myModal" >Edit</button>

                             
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                @endforeach  
                    
                </div>
            </div>
        </div>
    </div>
   <script>
   $(function(){
        $("table").dataTable();


               //edit ward
            $("button.edit").click(function () {
                // AAX FETCH RECOrd
                $("#wardId").val(this.id);
                var url = '{{url('/inpatient/editWard')}}'+'/'+this.id;
                $.ajax({
                    url:url
                }).done(function (data) {
                    console.info(data);
                    //attach data returned...
                    $("#name").val(data.name);
                    $("#category").val(data.category);
            })

        })

   })
    </script>
@endsection


 
 