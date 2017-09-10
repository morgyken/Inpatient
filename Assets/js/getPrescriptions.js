
function getPrescriptions(type){
	let table = (type == 0) ? "#single-prescriptions-table" :  "#regular-prescriptions-table";
    $.ajax({
        type: "GET",
        url: "{{ url('/api/inpatient/v1/prescriptions/admission/'.$admission->id).'/type/'}}"+type + "",
        dataType: 'json',
        success: function (resp) {                
            if(resp.type === "success"){
                if(resp.data.length > 0){
                    // refresh table
                    $("" + table + " > tbody tr").remove();
                    // Loop through and append rows
                    let data = resp.data;

                    if(type == 0){
                    	data.map( (item, index) => {
                            return(
                                $(""+table+" > tbody").append(
                                	"<tr id = 'row_"+ item.id +"'>\
						    			<td>" + item.drug + "</td>\
						    			<td>" + item.dose + "</td>\
						    			<td>" + item.by + "</td>\
						    			<td>" + item.prescribed_on + "</td>\
						    			<td>\
						    				<div class='btn-group'>\
						    					<button type='button' class='btn btn-danger cancel-o-prescription' id = '"+ item.id+"'><i class = 'fa fa-times' ></i> Cancel</button>\
						    				</div>\
						    			</td>\
						    		</tr>"
                                )
                            );
                        });
                    }else{
                    	data.map( (item, index) => {
                            return(
                                $(""+table+" > tbody").append(
                                	"<tr id = 'row_"+ item.id +"'>\
						    			<td>" + item.drug + "</td>\
						    			<td>" + item.dose + "</td>\
						    			<td>" + item.by + "</td>\
						    			<td>" + item.prescribed_on + "</td>\
						    			<td>\
						    				<div class='btn-group'>\
						    					<button class='btn btn-primary administer' id = '"+ item.id+"'><i class = 'fa fa-plus'></i> Administer</button>\
						    					<button type='button' class='btn btn-success view-logs' data-toggle='modal' href='#modal-view' id = '"+ item.id+"'><i class = 'fa fa-eye'></i> View</button>\
						    					<button type='button' class='btn btn-danger cancel-reg-prescription' id = '"+ item.id+"'><i class = 'fa fa-times' ></i> Cancel</button>\
						    				</div>\
						    			</td>\
						    		</tr>"
                                )
                            );
                        });
                    }
                   

                    $("" + table + "").css("display","block");
                    $("" + table + "").show();
                   
                }else{
                    $("" + table + "").css("display","none");
                    $("" + table + "").hide();
                    // alertify.error("No prescriptions found for this patient");
                }
            }else{
                alertify.error(resp.message);
            }
           
        },
        error: function (resp) {
        	$("" + table + "").hide();
        	alertify.error(resp.message);
        }
    });
}