<div role="tabpanel" id="investigation" class="tab-pane fade">
    <h3 class="text-center">Order New Investigations</h3>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        {{-- <div> --}}
            @include('inpatient::admission.manage.partials.investigations')
        {{-- </div> --}}
        <?php
			// $discount_allowed = json_decode(m_setting('evaluation.discount'));
   //          $type = 'laboratory';
        ?>

        {{-- {!! Form::open(['route'=> ['evaluation.order','laboratory']]) !!}
            {!! Form::hidden('visit', $admission->visit_id) !!}

                <div class="table-responsive">
                    @include('evaluation::partials.common.investigations.new')
                </div>
        {!! Form::close() !!} --}}
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    	<h3 class="text-center">Requested Investigations</h3>
        <div class="table-responsive">
        	<table class="table table-stripped table-hover table-condensed" id = "investigations-table">
        		<thead>
        			<tr>
        				<th>#</th>
        				<th>Procedure</th>
        				<th>Requested By</th>
        				<th>Requested On</th>
                        <th>Result</th>
                        <th>Action</th>
        			</tr>
        		</thead>
        		<tbody></tbody>
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

<script src="{{ m_asset('inpatient:js/inpatient-scripts.js') }}"></script>
<script src="{{ m_asset('evaluation:js/order_investigation.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        getInvestigations();

        function getInvestigations(){
             $.ajax({
                type: "GET",
                url: "{{ url('/api/inpatient/v1/investigations/visit/'. $admission->visit_id) }}",
                dataType: 'json',
                success: function (resp) {
                    if(resp.type === "success"){
                        if(resp.data.length > 0){
                            // refresh table
                            $("#investigations-table > tbody tr").remove();
                            // Loop through and append rows
                            let data = resp.data;
                            data.map( (item, index) => {
                                return(
                                    $("#investigations-table > tbody").append(
                                        "<tr id = 'row_"+ item.id +"'>\
                                            <td>" + item.id + "</td>\
                                            <td>" + item.procedure + "</td>\
                                            <td>" + item.user + "</td>\
                                            <td>" + item.requested_on + "</td>\
                                            <td></td>\
                                            <td><button type='button' class='btn btn-danger delete-investigation' id = '"+ item.id +"'><i class = 'fa fa-trash-o'></i> Delete</button></td>\
                                        </tr>"
                                    )
                                );
                            });

                            $("#investigations-table").css("display","block");
                            $("#investigations-table").show();
                           
                        }else{
                            $("#investigations-table").css("display","none");
                            // alertify.error("No requested investigations found for this patient");
                        }
                    }else{
                        $("#investigations-table").hide();
                        alertify.error(resp.message);
                    }
                },
                error: function (resp) {
                    alertify.error(resp.message);
                }
            });
        }

        $('#save_investigations').click(function(e){
            e.preventDefault();
             $.ajax({
                type: "POST",
                url: "{{ url('/api/inpatient/v1/investigations') }}",
                data: $('#investigations_form').serialize(),
                success: function (resp) {
                    alertify.success(resp);
                    // add table rows
                    getInvestigations();
                },
                error: function (resp) {
                    console.log(resp);
                    alertify.error('<i class="fa fa-check-warning"></i> Could not order investigations');
                }
            });
        });
    });
</script>
</div>