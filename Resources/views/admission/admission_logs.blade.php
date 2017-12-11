@extends('layouts.app')
@section('content_title','Previously admitted patients')
@section('content_description','Previously admitted patients')

@section('content')

    <div class="">
        <div class="">
            @if(count($admissions) < 0)
                <div class="box box-info">
                    <div class="box-body">
                        <span class="text-warning">The are no admissions recorded</span>
                    </div>
                </div>

            @else

                <div class="box box-info">
                    <div class="box-body">

                        <table class="table table-stripped table-condensed">
                            <thead>
                            <th>Name.</th>
                            <th>Admission Doc.</th>
                            <th>Ward</th>
                            <th>Bed</th>
                            <th>Cost</th>
                            <th>Admitted At</th>
                            <th>Discharged At</th>
                            <th>Option</th>
                            </thead>
                            <tbody>
                            @foreach($admissions as $admission)
                                <tr>
                                    <td>{{ $admission->patient->first_name }}
                                        {{ $admission->patient->last_name }}
                                    </td>
                                    @if(is_null($admission->doctor_id))
                                        <td>{{ $admission->external_doctor}}</td>
                                        @else
                                        <td>{{ $admission->doctor->profile->first_name }} {{ $admission->doctor->profile->last_name }}</td>
                                        @endif
                                    <td>{{ @$admission->ward->name }}</td>
                                    <td>{{ @$admission->bed->number }}</td>
                                    <td>{{ $admission->cost }}</td>
                                    <td>{{ $admission->created_at->format('H:i a d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($admission->wardAssigned->discharged_at)->format('H:i a d/m/Y') }}</td>
                                    <td>
                                       <button type="button" class="btn btn-default print_summary" id="{{ $admission->visit_id }}"><i class="fa fa-print"></i> Print Discharge Summary</button>&nbsp;
                                       <button  type="button" class="btn btn-default print_chargesheet" target="_blank" id = "{{ $admission->visit_id }}"><i class="fa fa-print"></i> Print Charge Sheet</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            @endif
        </div>

        <script type="text/javascript">
           

            $(document).ready(function(){
                $(".print_summary").click(function(e){ 
                    e.preventDefault();
                    var id = $(this).attr('id'); 
                    var SUMMARY_URL = "{{ url('/inpatient/summary/') }}/"+id;
                    var mywindow = window.open(SUMMARY_URL,"","top=50,left=400,  right=400,menubar=no,toolbar=no,scrollbars=yes,resizable=no,status=no");
                    mywindow.print();
                    // mywindow.close();
                });

                $(".print_chargesheet").click(function(e){
                    e.preventDefault();
                    var id = $(this).attr('id'); 
                    var mywindow = window.open("{{ url('/inpatient/chargesheet/') }}/"+id,"","top=50,left=400, right=400,menubar=no,toolbar=no,scrollbars=yes,resizable=no,status=no");
                    mywindow.print();
                    // mywindow.close();
               });
           });
                
        </script>
    </div>


@endsection