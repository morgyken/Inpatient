<div role="tabpanel" id="chargesheet" class="tab-pane fade col-md-12">
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
               <td>{{ $admission->created_at->format('jS M, Y H:i A ') }}</td>
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
                <td id = "total_recurrent_charge"><h5>Ksh. {{ number_format($charges['totalNursingAndWardCharges'], 2) }}</h5></td>
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
                <td colspan= "2" id = "total_procedures_charge">Ksh. {{ number_format($charges['procedures']->sum('amount'), 2) }}</td>
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
                <td colspan = "3" id = "total_investigations_charge">Ksh. {{ number_format($charges['investigations']->sum('amount'), 2) }}</td>
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
                    <td colspan = "2" id = "total_consumables_charge">Ksh. {{ number_format($charges['consumables']->sum('amount'), 2) }}</td>
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
                <td>{{ $admission->visit->payment_mode == 'cash' ?  $d->drugs->prices[0]->cash_price : $d->drugs->prices[0]->credit_price }}</td>
                <td>{{ $admission->visit->payment_mode == 'cash' ?  $d->drugs->prices[0]->cash_price * \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() : $d->drugs->prices[0]->credit_price * \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() }}</td>
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
                <td>{{ $admission->visit->payment_mode == 'cash' ?  $d->drugs->prices[0]->cash_price : $d->drugs->prices[0]->credit_price }}</td>
                <td>{{ $admission->visit->payment_mode == 'cash' ?  $d->drugs->prices[0]->cash_price * \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() : $d->drugs->prices[0]->credit_price * \Ignite\Inpatient\Entities\Administration::where("prescription_id", $d->id)->count() }}</td>
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
                <td colspan = "2" id = "total_prescription_charge">Ksh. {{ number_format($charges['totalPrescriptionCharges'], 2) }}</td>
            </tr>
            <tr>
                <th colspan="2">TOTAL BILL: Ksh. {{ $charges['totalBill'] }}</th>
                <th colspan="2">Max Allowed By Insurance: Ksh. 0</th>
                <th>PAID AMOUNT: Ksh. {{ number_format($charges['admission']->patient->account->balance, 2) }}</th>
                <th>BALANCE: Ksh. {{ number_format($charges['totalBill'] - $charges['admission']->patient->account->balance, 2) }}</th>
            </tr>
        </tfoot>
       </table>

       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <a class="btn btn-lg btn-default" target="_blank" id = "print-summary"><i class="fa fa-print"></i> Print</a>
       </div>

       <script type="text/javascript">
           $("#print-summary").click(function(e){
                e.preventDefault();
                window.open("{{ url('/inpatient/chargesheet/'.$admission->visit_id.'') }}","","top=50,left=400,  right=400,menubar=no,toolbar=no,scrollbars=yes,resizable=no,status=no");
           });
       </script>
</div>