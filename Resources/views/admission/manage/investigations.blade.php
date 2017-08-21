<div id="investigation" class="tab-pane fade">
    <h3 class="text-center">Order New Investigations</h3>

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            
        <?php
			$discount_allowed = json_decode(m_setting('evaluation.discount'));
            $type = 'laboratory';
        ?>
        {!! Form::open(['route'=>['evaluation.order','laboratory']])!!}
        {!! Form::hidden('visit',$admission->visit_id) !!}

        @include('evaluation::partials.common.investigations.new')

        {!! Form::close()!!}
        
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    	<h3 class="text-center">Investigations</h3>
    	<table class="table table-hover">
    		<thead>
    			<tr>
    				<th>#</th>
    				<th>Investigation</th>
    				<th>Result</th>
    				<th>Added By</th>
    				<th>Date & Time</th>
                    <th>Action</th>
    			</tr>
    		</thead>
    		<tbody>
    			<tr>
    				<td></td>
    				<td></td>
    				<td></td>
    				<td></td>
    				<td></td>
    			</tr>
    		</tbody>
    	</table>
    </div>
   
</div>

<?php
    $url = route('api.evaluation.get_procedures', ['laboratory', $admission->visit_id]);
?>
 <script>
    var PROCEDURE_URL = "{{ $url }}";
    var ORDERING = true;
</script>
<script src="{{ m_asset('evaluation:js/order_investigation.js') }}"></script>