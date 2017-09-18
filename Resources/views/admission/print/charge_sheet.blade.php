<link rel="stylesheet" href="{{url('/css/app.css')}}">
<style>
	body{
    margin: 0 auto;
    width: auto !important;
		padding: 5%;
    background: #ffffff !important;
	}
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 80%;
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

    <div class="box-body" style="width:100% !important;">
    	 <table class="table">
         <thead>
            <tr>
               <th colspan="4"><h2 class="text-center"><u>IN-PATIENT CHARGE SHEET</u></h2></th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <th>NAME OF PATIENT:</th>
               <td>{{ $charges['admission']->patient->fullname }}</td>
               <th>IP. NO.</th>
               <td>{{ $charges['admission']->id }}</td>
            </tr>
            <tr>
               <th>DATE OF ADMISSION</th>
               <td>{{ $charges['admission']->created_at->format('jS M, Y H:i A ')}}</td>
               <th>DATE OF DISCHARGE</th>
               <td>{{ ($charges['admission']->ward->discharged_at != null) ? \Carbon\Carbon::parse($charges['admission']->ward->discharged_at)->format('jS M, Y H:i A ') : 'Not Discharged' }}</td>
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
                 <th>Days</th>
                 <th>Rate</th>
                 <th>Total</th>
             </tr>
          </thead>
          <tbody>
            @foreach($charges['recurrent_charges'] as $c)
             <tr>
                <td>{{ $c->charge->name }}</td>
                <td>{{ $charges['daysAdmitted'] }}</td>
                <td>{{ $c->charge->cost }}</td>
                <td>{{ $c->charge->cost * $charges['daysAdmitted'] }}</td>
             </tr>
            @endforeach
            @foreach($charges['wards'] as $w)
              <tr>
                <td>Ward {{ $w->name }} ({{ $w->category }} {{ $w->cost }}/per day)  {{ ($w->discharged_at != null) ? \Carbon\Carbon::parse($w->discharged_at)->diffInDays($w->created_at) : \Carbon\Carbon::now()->diffInDays($w->created_at) }} days</td>
                <td>{{ ($w->discharged_at != null) ? \Carbon\Carbon::parse($w->discharged_at)->diffInDays($w->created_at) : \Carbon\Carbon::now()->diffInDays($w->created_at) }}</td>
                <td>{{ $w->price }}</td>
                <td>{{ $w->price * (($w->discharged_at != null) ? \Carbon\Carbon::parse($w->discharged_at)->diffInDays($w->created_at) : (\Carbon\Carbon::now()->diffInDays($w->created_at) > 0) ? Carbon\Carbon::now()->diffInDays($w->created_at) : 1 ) }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th colspan = "3"><h5>TOTAL</h5></th>
                <td id = "total_recurrent_charge"><h5>Ksh. {{ $charges['totalNursingAndWardCharges'] }}</h5></td>
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
            @foreach($charges['procedures'] as $p)
              <tr>
                <td>{{ $p->created_at->format('d/m/Y H:i a') }}</td>
                <td>{{ $p->procedures->name }}</td>
                <td>{{ $p->quantity }}</td>
                <td>{{ $p->price }}</td>
                <td>{{ $p->amount }}</td>
                <td>{{ $p->isPaid ? 'Yes' : 'No' }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th colspan = "4"><h5>TOTAL</h5></th>
                <td colspan= "2" id = "total_procedures_charge">Ksh. {{ $charges['procedures']->sum('amount') }}</td>
            </tr>
        </tfoot>
       </table>

       <table class="table table-hover table-bordered">
          <thead>
             <tr>
                <th colspan="7" class="text-center">INVESTIGATIONS</th>
             </tr>
             <tr>
                <th>DATE</th>
                <th>CATEGORY</th>
                <th>ITEM</th>
                <th>UNITS</th>
                <th>UNIT COST</th>
                <th>TOTAL COST</th>
                <th>PAID</th>
             </tr>
          </thead>
          <tbody>
            @foreach($charges['investigations'] as $i)
              <tr>
                <td>{{ $i->created_at->format('d/m/Y H:i a') }}</td>
                <td>{{ $i->procedures->categories->name }}</td>
                <td>{{ $i->procedures->name }}</td>
                <td>{{ $i->quantity }}</td>
                <td>{{ $i->price }}</td>
                <td>{{ $i->amount }}</td>
                <td>{{ $i->isPaid ? 'Yes' : 'No' }}</td>
              </tr>
            @endforeach
          </tbody>
           <tfoot>
            <tr>
                <th colspan = "4"><h5>TOTAL</h5></th>
                <td colspan = "3" id = "total_investigations_charge">Ksh. {{ $charges['investigations']->sum('amount') }}</td>
            </tr>
        </tfoot>
       </table>

       @if($charges['consumables']->count() > 0)
           <table class="table table-bordered">
               <thead>
                   <tr>
                       <th colspan="6" class="text-center">CONSUMPTION LIST</th>
                   </tr>
                   <tr>
                       <th>DATE</th>
                       <th>ITEM</th>
                       <th>UNITS USED</th>
                       <th>UNIT COST</th>
                       <th>TOTAL COST</th>
                       <th>PAID</th>
                   </tr>
               </thead>
               <tbody>
                    @foreach($charges['consumables'] as $c)
                       <tr>
                           <td>{{ $c->created_at->format('d/m/Y H:i a') }}</td>
                           <td>{{ $c->product->name }}</td>
                           <td>{{ $c->quantity }}</td>
                           <td>{{ $c->price > 0 ? $c->price : 0 }}</td>
                           <td>{{ $c->amount }}</td>
                           <td>{{ $c->is_paid ? 'Yes' :  'No'}}</td>
                       </tr>
                   @endforeach
               </tbody>
               <tfoot>
                <tr>
                    <th colspan = "4"><h5>TOTAL</h5></th>
                    <td colspan = "2" id = "total_consumables_charge">Ksh. {{ $charges['consumables']->sum('amount') }}</td>
                </tr>
            </tfoot>
           </table>
        @endif

       <table class="table table-hover table-bordered">
        <thead>
             <tr>
                <th colspan="6" class="text-center">PHARMACY</th>
             </tr>
            <tr>
                <th>DATE</th>
                <th>DRUG NAME</th>
                <th>UNITS GIVEN</th>
                <th>UNIT COST</th>
                <th>TOTAL COST</th>
                <th>PAID</th>
            </tr>
        </thead>
        <tbody>
          @foreach($charges['dispensed_drugs'] as $d)
            <tr>
                <td>{{ $d->created_at->format('d/m/Y H:i a') }}</td>
                <td>{{ $d->drugs->name }}</td>
                <td>{{ \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() }}</td>
                <td>{{ $charges['admission']->visit->payment_mode == 'cash' ?  $d->drugs->prices[0]->cash_price : $d->drugs->prices[0]->credit_price }}</td>
                <td>{{ $charges['admission']->visit->payment_mode == 'cash' ?  $d->drugs->prices[0]->cash_price * \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() : $d->drugs->prices[0]->credit_price * \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() }}</td>
                <td>
                  @if(\Ignite\Evaluation\Entities\Dispensing::where('prescription', $d->id)->first() != null )
                    {{ (\Ignite\Evaluation\Entities\Dispensing::where('prescription', $d->id)->first()->payment_status == 0) ? 'No' : 'Yes' }}
                  @else
                    No
                  @endif
                  </td>
            </tr>
          @endforeach
          @foreach($charges['discharge_drugs'] as $d)
            <tr>
                <td>{{ $d->created_at->format('d/m/Y H:i a') }}</td>
                <td>{{ $d->drugs->name }}</td>
                <td>{{ \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() }}</td>
                <td>{{ $charges['admission']->visit->payment_mode == 'cash' ?  $d->drugs->prices[0]->cash_price : $d->drugs->prices[0]->credit_price }}</td>
                <td>{{ $charges['admission']->visit->payment_mode == 'cash' ?  $d->drugs->prices[0]->cash_price * \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() : $d->drugs->prices[0]->credit_price * \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() }}</td>
                <td>
                  @if(\Ignite\Evaluation\Entities\Dispensing::where('prescription', $d->id)->first() != null )
                    {{ (\Ignite\Evaluation\Entities\Dispensing::where('prescription', $d->id)->first()->payment_status == 0) ? 'No' : 'Yes' }}
                  @else
                    No
                  @endif
                </td>
            </tr>
          @endforeach
        </tbody>
         <tfoot>
            <tr>
                <th colspan = "4"><h5>TOTAL</h5></th>
                <td colspan = "2" id = "total_prescription_charge">Ksh. {{ $charges['totalPrescriptionCharges'] }}</td>
            </tr>
            <tr>
                <th colspan="2">TOTAL BILL: Ksh. {{ $charges['totalBill'] }}</th>
                <th colspan="2">Max Allowed By Insurance: Ksh. 0</th>
                <th>PAID AMOUNT: Ksh. {{ $charges['admission']->patient->account->balance }}</th>
                <th>BALANCE: Ksh. {{ $charges['totalBill'] - $charges['admission']->patient->account->balance }}</th>
            </tr>
        </tfoot>
       </table>

       <br/><br/><br/><br/>

       <table class="table table-hover" style="border: none !important;">
         <tbody style="border: none !important;">
           <tr style="border: none !important;">
              <td style="border: none !important;" colspan="2"><u>{{$charges['admission']->full_name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td style="border: none !important; padding-left: 25% !important;" colspan="2"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
           </tr>
           <tr style="border: none !important;">
              <td style="border: none !important;" colspan="2"><strong>CASHIER'S NAME AND SIGNATURE</strong></td>
              <td style="border: none !important; padding-left: 25% !important;" colspan="2"><strong>DATE</strong></td>
           </tr>
         </tbody>
       </table>

      
</div>


<hr>