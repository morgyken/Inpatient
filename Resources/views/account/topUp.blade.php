@extends('layouts.app')
@section('content_title','top up')
@section('content_description','Credit the patient\'s account')

@section('content')
    @include('Evaluation::inpatient.success')

<div class="box box-info">
    <div class="box-body">
        <form action="{{url('/evaluation/inpatient/topUpAmount')}}" method="post">
            <div class="col-lg-6">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <label for="" class="control-label">Select Patient:</label>
                <select required name="patient_id" id="" class="form-control">
                    @foreach($patients as $patient)
                        <option value="{{$patient->id}}">{{$patient->first_name}} {{$patient->middle_name}} {{$patient->last_name}} </option>
                        @endforeach
                </select>

                <label for="" class="control-label">Amount</label>
                <input required type="number" name="amount" class="form-control">
                <br>
                <button class="btn btn-primary" type="submit">Top Up Account</button>
            </div>
        </form>
    </div>

    <div class="box-body">
        <table class="table table-stripped condensed">
            <thead>
            <th>Reference</th>
            <th>Amount Deposited</th>
            <th>Patient</th>
            <th>Date</th>
            </thead>
            <tbody>
            @foreach($deposits as $deposit)
                <tr>
                    <td>{{$deposit->reference}}</td>
                    <td>Kshs. {{$deposit->credit}}</td>
                    <td>
                        {{\Ignite\Reception\Entities\Patients::find($deposit->patient)->first_name}}
                       </td>
                    <td>{{$deposit->created_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


</div>
    <script>
        $(function () {
            $("table").dataTable();
            $("select").select2();
        })
    </script>

@endsection