@extends('layouts.app')
@section('content_title','Add Bed')
@section('content_description','Allocate more beds to Existing wards')

@section('content')
    @include('Inpatient::includes.success')

    <div class="box box-info">
        <div class="box-body">
            <div class="row">
                <div class="form-horizontal">
                    {!! Form::open(['url'=>'/inpatient/beds/postaddbed']) !!}
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                                <label class="control-label col-md-4">bed number</label>
                                <div class="col-md-8">
                                     <input required  type="text" name="number" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4">Bed Type</label>
                                <div class="col-md-8">
                                   <select name="type" required class="form-control">
                                        @if($bedTypes->count() > 0)
                                            @foreach($bedTypes as $b)
                                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                                            @endforeach
                                        @else
                                            <option selected>Add bed Positions First!</option>
                                        @endif
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
        </div>

        <!-- Trigger the modal with a button -->


        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Bed</h4>
                    </div>
                    <div class="modal-body">
                        <div>
                            <input type="hidden" name="bed_id" id="bed_id">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <label for="" class="control-label">Bed No.</label>
                            <input type="text" id="bed_no" class="form-control" name="bed_no">

                            <label for="bed_type" class="control-label">Select Type</label>
                                <select name="bed_type" id = "bed_type" required class="form-control">
                                    @if($bedTypes->count() > 0)
                                        @foreach($bedTypes as $b)
                                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected>Add bed Positions First!</option>
                                    @endif
                                </select>

                            <label for="" class="control-label">Select Ward</label>
                            <select name="ward" id="" class="form-control">
                                @foreach($wards as $ward)
                                    <option value="{{$ward->id}}">{{$ward->number}} {{$ward->name}}</option>
                                    @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit"> Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="box-body">
            <table class="table table-stripped condensed">
                <caption>The Beds List: All The Beds</caption>
                <thead>
                <th>Bed No.</th>
                <th>Type</th>
                <th>Status</th>
                <th>Added At</th>
                <th>Actions</th>
                </thead>
                <tbody>
                @foreach($beds as $bed)
                    <tr>
                        <td>{{$bed->number}}</td>
                        <td>{{$bed->bedType->name}}</td>
                        <td>{{$bed->status}}</td>
                        <td>{{$bed->created_at}}</td>

                        <td class="horizontal">
                            <a href="{{url('/inpatient/beds/delete_bed/'.$bed->id)}}" class="btn btn-xs btn-danger">Delete Bed</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


    </div>
        <script>
            $(function () {
                $("table").dataTable();
                $(".editBed").click(function () {
                    var bed_id = this.value;
                    $("#bed_id").val(bed_id);
                    var url = '{{url('/inpatient/beds/editBed')}}' + '/' + bed_id;
                    $.ajax({
                        url: url,
                        method:'GET'
                    }).done(function (data) {
                        $("#bed_no").val(data.number);
                        $("#bed_type").val(data.type);
                        $("#Sward_id").val(data.ward_id);
                    })
                })
            })
        </script>

@endsection