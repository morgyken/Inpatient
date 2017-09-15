<div role="tabpanel" id="chargesheet" class="tab-pane fade col-md-12">
	<h3 class="text-center">INPATIENT CHARGE SHEET</h3>

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
</div>