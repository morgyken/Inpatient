<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Administer Prescription</h4>
			</div>
			<div class="modal-body">
				<form role="form">
					{{ csrf_field() }}
					<input type = "hidden" name = "prescription_id" id = "prescription_id"/>
					<div class="form-group">
						<label>Time Administered</label>
						<input type="time" name = "time" id = "time" class="form-control" placeholder="Time" required/>
					</div>
					<div class="form-group">
						<label>AM or PM</label>
						<select name="am_pm" id="am_pm" class="form-control" required>
							<option value="am">AM</option>
							<option value ="pm">PM</option>
						</select>
					</div>				
					<button type="button" class="btn btn-primary" id = "administer_drug">Administer</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>