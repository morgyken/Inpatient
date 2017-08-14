<link rel="stylesheet" href="{{url('/css/app.css')}}">
<style>
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th{
        border: 1px solid #ddd;
        text-align: left;
        padding: 1px;
    }

    table tr:nth-child(even){background-color: #f2f2f2}

    table tr:hover {background-color: #ddd;}

    table th{
        padding-top: 1px;
        padding-bottom: 1px;
        background-color: /*#4CAF50*/ #BBBBBB;
        color: white;
    }
    .left{
        width: 60%;
        float: left;
    }
    .right{
        float: left;
        width: 40%;
    }
    .clear{
        clear: both;
    }
    img{
        width:50%;
        height: 50%/*auto*/;
        float: right;
    }
    td{
        font-size: 70%;
    }
    div #footer{
        font-size: 70%;
    }
    th{
        font-size: 80%;
    }
</style>

<div class="box box-info">
    <img src="{{realpath(base_path('/public/logo.png'))}}"/>
    <div class="box-header with-border">
        <h3 class="box-title">{{config('practice.name')}}</h3>
        {{config('practice.building')?config('practice.building').',':''}}
        {{config('practice.street')?config('practice.street').',':''}}
        {{config('practice.town')}}<br>
        {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br>

    </div>
    <div class="box-body">
        <div class="col-md-12">
            <br>
            <strong>Name:</strong><span class="content"> {{$patient->full_name}}</span><br/>
            <strong>Account Balance:</strong><span class="content"> Kshs. {{number_format($acc->balance,2)}}</span><br/>
            <strong>Date:</strong><span class="content"> {{(new Date())->format('j/m/Y H:i')}}</span><br/>
            <br/><br/>
        </div>
        <div class="col-md-6">
          
                <table class="table table-striped" id="items">
                <caption>Deposit Transactions</caption>
                    <thead>
                    <tr>
                    <th>#</th>
                    <th>Reference</th>
                    <th>Deposit Amount</th>
                    <th>Mode</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    ?>
                    @foreach($trans as $tran)

                    <tr>
                        <td>{{$loop->index +1}}</td>
                        <td>{{$tran->reference}}</td>
                        <td>{{$tran->credit}}</td>
                        <td>{{$tran->mode}}</td>
                    </tr>
                        <?php
                        $total += $tran->credit;
                        ?>
                    @endforeach()

                   </tbody>
                    <tfoot>
                    <tr>
                        <th style="text-align:right" colspan='2'>Amount Paid</th>
                        <th>Kshs. {{number_format($total,2)}}</th>
                    </tr>
                    </tfoot>
                </table>
                
    <hr/>
    <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>

    <br/><br/>
    <u>Payment Confirmed by: <u>{{$patient->full_name}}</u>
</div>


<hr>