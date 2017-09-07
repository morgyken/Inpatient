<div id="investigation" class="tab-pane fade">
    <h3 class="text-center">Order New Investigations</h3>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            
        <?php
			$discount_allowed = json_decode(m_setting('evaluation.discount'));
            $type = 'laboratory';
        ?>

        <form id = "investigations_form" role="form">       
        {{-- {!! Form::open(['route'=> ['evaluation.order','laboratory']]) !!} --}}
        {!! Form::hidden('visit', $admission->visit_id) !!}

            <div class="table-responsive">
                @include('evaluation::partials.common.investigations.new')
            </div>
        </form>
        {!! Form::close() !!}
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    	<h3 class="text-center">Requested Investigations</h3>
        <div class="table-responsive">
        	<table class="table table-stripped table-condensed" id = "investigations-table">
        		<thead>
        			<tr>
        				<th>#</th>
        				<th>Procedure</th>
        				<th>Result</th>
        				<th>Added By</th>
        				<th>Date & Time</th>
                        <th>Action</th>
        			</tr>
        		</thead>
        		<tbody id = "investigations-table-body">
                @foreach($investigations as $i)
        			<tr>
        				<td>{{ $i['id'] }}</td>
        				<td>{{ $i['procedure'] }}</td>
        				<td></td>
        				<td>{{ $i['user'] }}</td>
        				<td>{{ $i['requested_on'] }}</td>
                        <td></td>
        			</tr>
                @endforeach
        		</tbody>
        	</table>
        </div>
    </div>
   
</div>

<?php
    $url = route('api.evaluation.get_procedures', ['laboratory', $admission->visit_id]);
?>

 <script>
    var PROCEDURE_URL = "{{ $url }}";
    var ORDERING = true;
</script>

<script src="{{ m_asset('inpatient:js/inpatient-scripts.js') }}"></script>
<script src="{{ m_asset('evaluation:js/order_investigation.js') }}"></script>
