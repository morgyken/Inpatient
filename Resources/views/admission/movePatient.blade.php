@extends('layouts.app')
@section('content_title','Move Patient')
@section('content_description','Change patient wards and beds')

@section('content')
    @include('Evaluation::inpatient.success')

    <div class="box box-info">
        <div class="box-body">
            <h2>Patient Details</h2>
            <div class="col-lg-6">
                <strong> Name: </strong> {{$patient->full_name}}<br>
                <strong>Number:</strong>  {{$patient->id}}<br>

                <strong> Current Bed Number: </strong> {{$bed}}<br>
              
              <br>
                <strong>Bed Position:</strong>  {{$bed}}<br>
              
                <strong>Current Ward:</strong> {{$ward->name}}  <br>
            </div>


            <div class="form-horizontal">
        {!! Form::open(['url'=>'/inpatient/beds/change_bed']) !!}
        <div class="col-md-6">
            <input type="hidden" name="admission_id" value='{{$admission->id}}'>
            <div class="">
                <div class="form-group {{ $errors->has('ward_id') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Ward:</label>
                    <div class="col-md-8">
                        <select name="ward_id" class="form-control" id="ward">
                            @foreach($wards as $ward)
                                <option value="{{$ward->id}}">
                                    {{$ward->name}} / No: {{$ward->number}} @ Kshs. {{number_format($ward->cost,2)}}
                                </option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('bedposition_id') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Bed Position:</label>
                    <div class="col-md-8">
                         <select name="bedposition_id" class="form-control" id="bedPosition">
                        </select>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('bed_id') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Select Bed:</label>
                    <div class="col-md-8">
                        <select name="bed_id" class="form-control" id="bed">
                            @foreach($beds as $ward)
                                <option value="{{$ward->id}}">
                                   Bed Number: {{$ward->number}}
                                </option>
                                @endforeach
                        </select>
                    </div>
                </div>
                

                <div class="pull-right">
                    <button class="btn btn-success pull-right" type="submit"> <i class="fa fa-share"></i> Move</button>
                </div>
            </div>
        </div> 
        {!! Form::close() !!}
    </div>
        
        </div>

    </div>
    <hr>


    <script>

        $(function () {
            $("table").dataTable();

           var getbedp = function () {

                var ward = $("#ward").val();
                $("#bedPosition").html('');
            
                    var urlAvailableBeds = '{{ url('/inpatient/beds/availableBeds/') }}';
                    urlAvailableBeds = urlAvailableBeds + '/' + ($("#ward").val());
                    
                    $.ajax({
                        url:urlAvailableBeds,
                        method:'GET'
                    }).done(function (data) {
                        $("#bedPosition").html("");
                       $.each(data, function (index,value) {
                                // console.info("index=>"+index+'value=>'+value.number);
                                $("#bedPosition").append("<option value='"+value.id+"'>"+value.name+"</option>")
                            });
                    });
            }

               getbedp();

               $("#ward").change(function () {
                   getbedp();
               });
           }); 

    </script>

@endsection