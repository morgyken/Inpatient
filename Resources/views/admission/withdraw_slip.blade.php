<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"  media='all'>
<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>
</head>
<body>

<div id="mydiv">
    <h2>
       Withdraw Slip
    </h2>
    <p>Name: {{$patient->first_name}} {{$patient->last_name}}</p>
    <p>Date: <?php echo(date_format(new Date(),'y/d/m'))?></p>
    <p>Reference: {{$wit->reference}}</p>
    <p>Amount Deposited: {{$wit->debit}}</p>
    <p>Account Balance: {{$balance}}</p>

</div>

<button class="btn btn-primary" onclick="PrintElem('#mydiv')" >Print</button>
<a href="{{url('/evaluation/inpatient/topUp')}}" class="btn btn-info" >Back</a>