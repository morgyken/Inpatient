<link rel="stylesheet" href="{{url('/css/app.css')}}">
<style>
	body{
		padding: 1%;
	}
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th{
        /*border: 1px solid #ddd;*/
        text-align: left;
        padding: 1px;
    }

    table th{
        padding-top: 1px;
        padding-bottom: 1px;
        color: #333;
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
    	margin: 0 auto;
        width:100%;
    }
    td{
        font-size: 80%;
    }
    div #footer{
        font-size: 70%;
    }
    th{
        font-size: 90%;
    }

    .sections{
    	margin-bottom: 10px;
    }

    .sections h4{
    	text-decoration: underline;
    }

    #print-header{
    	border: none !important;
    }

    #logo-side{
    	width: 30%;
    }

    #company-info-side{
    	width: 70%;
    	font-size: 
    }

    #company-name{
    	font-size: 3em;
    }

    #company-details{
    	font-size: 1em;
    }
</style>

<div class="box box-info">
	<table id = "print-header">
		<thead>
			<tr>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr id = "header-tr">
				<td id = "logo-side"><img src="{{ asset('/logos/collabmed14dDqP.png') }}"/></td>
				<td id = "company-info-side" class="text-center">
					<h3 id ="company-name">{{ strtoupper(config('practice.name')) }}</h3>
					<span id = "company-details">
				        {{ config('practice.building') ? config('practice.building').',' : ''}}
				        {{ config('practice.street') ? config('practice.street').',' : ''}}
				        {{ config('practice.town') }}<br>
				        {{ config('practice.address') ? 'P.O.Box '. config('practice.address').',' : '' }}
				        {{ config('practice.telephone') ? 'Tell: '. config('practice.telephone') : ''}}<br/>
				        {{ config('practice.email') ? 'Email: '. strtolower(config('practice.email')) : ''}}
			    	</span>
			    </td>
			</tr>
		</tbody>
	</table>

    <div class="box-body">
    	<table class="table">
    		<thead>
    			<tr>
    				<th colspan="4"><h2 class="text-center"><u>IN-PATIENT CHARGE SHEET</u></h2></th>
    			</tr>
    		</thead>
    		<tbody>
    			<tr>
    				<th>NAME OF PATIENT:</th>
    				<td>{{ $admission->patient->fullname }}</td>
    				<th>IP. NO.</th>
    				<td>{{ $admission->id }}</td>
    			</tr>
    			<tr>
    				<th>DATE OF ADMISSION</th>
    				<td>{{ $admission->created_at->format('jS M, Y H:i A ')}}</td>
    				<th>DATE OF DISCHARGE</th>
    				<td></td>
    			</tr>
    		</tbody>
    	</table>

    	 <table class="table table-hover table-bordered">
          <thead>
             <tr>
                <th colspan="4" class="text-center">NURSING CHARGES/WARD</th>
             </tr>
             <tr>
                 <th>Description</th>
                 <th>Qty</th>
                 <th>Rate</th>
                 <th>Total</th>
             </tr>
          </thead>
          <tbody>
             <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
             </tr>
          </tbody>
          <tfoot>
            <tr>
                <td colspan = "3"><h5>TOTAL</h5></td>
                <td id = "total_recurrent_charge"></td>
            </tr>
        </tfoot>
       </table>

        <table class="table table-hover table-bordered">
          <thead>
             <tr>
                <th colspan="6" class="text-center">PROCEDURES</th>
             </tr>
             <tr>
                <th>DATE</th>
                <th>ITEM</th>
                <th>NO. GIVEN</th>
                <th>UNIT COST</th>
                <th>TOTAL COST</th>
                <th>PAID</th>
             </tr>
          </thead>
          <tbody>
             <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
             </tr>
          </tbody>
          <tfoot>
            <tr>
                <td colspan = "4"><h5>TOTAL</h5></td>
                <td id = "total_procedures_charge"></td>
                <td></td>
            </tr>
        </tfoot>
       </table>

       <table class="table table-hover table-bordered">
          <thead>
             <tr>
                <th colspan="6" class="text-center">INVESTIGATIONS</th>
             </tr>
             <tr>
                <th>DATE</th>
                <th>CATEGORY</th>
                <th>ITEM</th>
                <th>UNIT COST</th>
                <th>TOTAL COST</th>
                <th>PAID</th>
             </tr>
          </thead>
          <tbody>
             <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
             </tr>
          </tbody>
           <tfoot>
            <tr>
                <td colspan = "4"><h5>TOTAL</h5></td>
                <td id = "total_investigations_charge"></td>
                <td></td>
            </tr>
        </tfoot>
       </table>

       <table class="table table-hover table-bordered">
        <thead>
             <tr>
                <th colspan="6" class="text-center">PHARMACY</th>
             </tr>
            <tr>
                <th>DATE</th>
                <th>DRUG NAME</th>
                <th>UNITS</th>
                <th>UNIT COST</th>
                <th>TOTAL COST</th>
                <th>PAID</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan = "4"><h5>TOTAL</h5></td>
                <td id = "total_prescription_charge"></td>
                <td></td>
            </tr>
        </tfoot>
       </table>
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 !important;">
    		<div class="col-md-8">
    			<u>{{$admission->full_name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br/>
    			<strong>CASHIER'S NAME AND SIGNATURE</strong>
    		</div>
    		<div class=" col-offset-2 col-md-2"  style="padding: 0 !important;">
    			<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br/>
    			<strong>DATE</strong>
    		</div>
    	</div>

      
</div>


<hr>