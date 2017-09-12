<div role="tabpanel" id="discharge" class="tab-pane fade col-lg-12">
  <form role="form">  
  	<div class="form-group">
  		<label>Principal Diagnosis</label>
  		<textarea name="principal_diagnosis" id="principal_diagnosis" class="form-control" rows="3" cols = "10" required></textarea>
  	</div>
  	<div class="form-group">
  		<label>Other Diagnosis</label>
  		<textarea name="other_diagnosis" id="other_diagnosis" class="form-control" rows="3" cols = "10" required></textarea>
  	</div>
  	<div class="form-group">
  		<label>Complaints at Admission</label>
  		<textarea name="complaints" id="complaints" class="form-control" rows="3" cols = "10" required></textarea>
  	</div>
  	<div class="form-group">
  		<label>Discharge Conditions</label>
  		<textarea name="discharge_conditions" id="discharge_conditions" class="form-control" rows="3" cols = "10" required></textarea>
  	</div>  
  	<button type="submit" class="btn btn-primary" id = "save_discharge_summary">Save</button>&nbsp;<button type="button" class="btn btn-default" id = "print_summary" style="display: none !important;">Print</button>
  </form>
</div>