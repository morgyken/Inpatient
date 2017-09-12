$(document).ready(function(){
    // $("#single-prescriptions-table").dataTable();
    // $("#regular-prescriptions-table").dataTable();

    getTime();

	function getTime(){
		var d = new Date();
		let timeNow = d.getHours() + ':' + d.getMinutes();
		$("#time").val(timeNow);
	}

    $("#time").timepicker({ 'scrollDefault': 'now' });

    $('.administer,.administer-once').click(function(e){
    	e.preventDefault();
    	var id = $(this).attr('id');
    	getTime();
    	$("#prescription_id").val(id);
		$("#modal-id").modal();			
	});

    $('#savePrescription').click(function(e){
        e.preventDefault();
        let pre_type = ($("#type").is(":checked")) ? 1 : 0;
        let data = JSON.stringify({
                 	visit : VISIT_ID,
                 	admission_id: ADMISSION_ID,
                	user: USER_ID,
					drug: $("#item_0").val(),
					take: parseInt($("#take").val()),
					whereto: parseInt($("#whereto").val()),
					method: parseInt($("#method").val()),
					duration: parseInt($("#duration").val()),
					time_measure: parseInt($("#time_measure").val()),
					allow_substitution: $("#allow_substitution").is(":checked"),
                 	type: pre_type
           		});

         $.ajax({
            type: "POST",
            url: PRESCRIPTIONS_URL,
            data: data,
            success: function (resp) {
                // add table rows
                 if(resp.type === "success"){
                 	alertify.success(resp.message);
                 	// Append to Respective row
						let data = resp.data;
                    // console.log(resp.data);
                 	if(pre_type == 0){
                 		// Append to Once only prescription table
                        data.map( (item, index) => {
                            return(
                                $("#single-prescriptions-table > tbody").append("<tr id = 'once_row_"+ item.id +"'>\
                                	<td>"+ item.drug +"</td>\
                                    <td>" + item.dose + "</td>\
                                    <td>"+ item.prescribed_by +"</td>\
                                    <td>"+ item.prescribed_on +"</td>\
                                    <td><div class='btn-group'>\
			    					<button type='button' class='btn btn-info'><i class = 'fa fa-exclamation-circle'></i> Dispensing</button>\
				    				<button type='button' class='btn btn-danger cancel-o-prescription' id = '"+ item.id +"'><i class = 'fa fa-times' ></i> Cancel</button>\
			    				</div></td></tr>")
                            ); 
                        });
                 	}else{
                 		// Append to Regular prescription table
                        data.map( (item, index) => {
                            return(
                                $("#regular-prescriptions-table > tbody").append("<tr id = 'reg_row_"+ item.id +"'>\
                                	<td>"+ item.drug +"</td>\
                                    <td>" + item.dose + "</td>\
                                    <td>"+ item.prescribed_by +"</td>\
                                    <td>"+ item.prescribed_on +"</td>\
                                    <td><div class='btn-group'>\
			    					<button type='button' class='btn btn-info'><i class = 'fa fa-exclamation-circle'></i> Dispensing</button>\
			    					<button type='button' class='btn btn-danger cancel-reg-prescription' id = '"+ item.id +"'><i class = 'fa fa-times' ></i> Cancel</button>\
			    				</div></td></tr>")
                            );
                        });
                 	}
                    alertify.success(resp.message);
                }else{
                	 alertify.error(resp.message);
                }
            },
            error: function (resp) {
                alertify.error(resp.message);
            }
        });
    });

   	$('body').on('click', '.stop-o-prescription', function(e){
    	e.preventDefault();
    	let id =  $(this).attr('id');
    	$(".yes-stop-prescription").attr('id', id); 
    	$("#is_stop_reg").val(0); 
        $("#modal-stop-prescription").modal();
    });

    $('body').on('click', '.stop-reg-prescription', function(e){
    	e.preventDefault();
    	let id =  $(this).attr('id');
    	$(".yes-stop-prescription").attr('id', id); 
    	$("#is_stop_reg").val(1); 
        $("#modal-stop-prescription").modal();
    });

    $('body').on('click', '.cancel-o-prescription', function(e){
    	e.preventDefault();
    	let id =  $(this).attr('id');
    	$(".yes-cancel-prescription").attr('id', id); 
    	$("#is_reg").val(0); 
        $("#modal-cancel-prescription").modal();
    });

    $('body').on('click', '.cancel-reg-prescription',function(e){
    	e.preventDefault();
    	let id =  $(this).attr('id');
    	$(".yes-cancel-prescription").attr('id', id); 
    	$("#is_reg").val(1); 
        $("#modal-cancel-prescription").modal();
    });

    $('.yes-cancel-prescription').click(function(e){
        var id = $(this).attr('id');
        var type = parseInt($("#is_reg").val());
        var reason = $.trim($("#cancel_reasons").val());
        if(reason.length > 0){
            $.ajax({
                type: "POST",
                url: PRESCRIPTIONS_DELETE_URL,
                data: JSON.stringify({ id : id, reason: reason }),
                success: function (resp) {
                     if(resp.type === "success"){
                        alertify.success(resp.message);
                        if(type == 1){
                        	$("#reg_row_"+id+"").remove();
                    	}else if(type == 0){
                    		$("#once_row_"+id+"").remove();
                    	}
                    	$("#modal-cancel-prescription").modal('toggle');
                    }else{
                         alertify.error(resp.message);
                    }
                },
                error: function (resp) {
                    alertify.error(resp.message);
                }
            });
     	}else{
     		alertify.error("You must first provide a reason for cancellation!");
     	}
    });

    $('.yes-stop-prescription').click(function(e){
        var id = $(this).attr('id');
        var type = parseInt($("#is_stop_reg").val());
        var reason = $.trim($("#stop_reasons").val());
        if(reason.length > 0){
        	$.ajax({
                type: "POST",
                url: PRESCRIPTIONS_STOP_URL,
                data: JSON.stringify({ id : id, reason: reason }),
                success: function (resp) {
                     if(resp.type === "success"){
                        alertify.success(resp.message);
                        if(type == 1){
                        	$("#reg_row_"+id+"").remove();
                    	}else if(type == 0){
                    		$("#once_row_"+id+"").remove();
                    	}
                    	$("#modal-stop-prescription").modal('toggle');
                    }else{
                         alertify.error(resp.message);
                    }
                },
                error: function (resp) {
                    alertify.error(resp.message);
                }
            });
        }else{
     		alertify.error("You must first provide a reason for stopping this prescription!");
     	}
    });


    $('#administer_drug').click(function(e){
    	e.preventDefault();
		
		let data = JSON.stringify({ 
			admission_id : ADMISSION_ID,
			prescription_id : $("#prescription_id").val(),
			visit_id : VISIT_ID,
			time : $("#time").val(),
			user: USER_ID
		});

    	$.ajax({
            type: "POST",
            url: ADMINISTER_PRESCRIPTION_URL,
            data: data,
            success: function (resp) {
                 if(resp.type === "success"){
                    alertify.success(resp.message);
                    $("#modal-id").modal();
                }else{
                	 alertify.error(resp.message);
                }
            },
            error: function (resp) {
                alertify.error(resp.message);
            }
        });

    });

    function getLogs(id){
    	$.ajax({
	        type: "GET",
	        url: GET_LOGS_URL+"/"+ id +"",
	        dataType: 'json',
	        success: function (resp) {                
	            if(resp.type === "success"){
	                if(resp.data.length > 0){
	                    // refresh table
	                    $("#admin-logs-table > tbody tr").remove();
	                    // Loop through and append rows
	                    let data = resp.data;
                    	data.map( (item, index) => {
                            return(
                                $("#admin-logs-table > tbody").append(
                                	"<tr id = 'row_"+ item.id +"'>\
						    			<td>" + item.dose + "</td>\
						    			<td>" + item.recorded_by + "</td>\
						    			<td>" + item.recorded_on + "</td>\
						    			<td><button type='button' class='btn btn-danger delete-log' id = '"+ item.id+"'><i class = 'fa fa-times' ></i> Cancel</button>\
						    			</td>\
						    		</tr>"
                                )
                            );
                        });

                        $("#modal-view").modal();

	                }else{
	                    alertify.error("No administration logs found for this patient");
	                }
	            }else{
	                alertify.error(resp.message);
	            }
	           
	        },
	        error: function (resp) {
	        	alertify.error(resp.message);
	        }
	    });
    }

    $('body').on('click', '.view-logs', function(e){
    	e.preventDefault();
    	var id = $(this).attr('id');
    	getLogs(id);
    });


    $('body').on('click', '.delete-log', function(e){
    	e.preventDefault();
		var id = $(this).attr('id');
		let data = JSON.stringify({ id : id });
    	$.ajax({
            type: "POST",
            url: DELETE_ADMINISTRATION_URL,
            data: data,
            success: function (resp) {
                 if(resp.type === "success"){
                    alertify.success(resp.message);
                    $("#admin-logs-table > tbody #row_"+id+"").remove();
                }else{
                	 alertify.error(resp.message);
                }
            },
            error: function (resp) {
                alertify.error(resp.message);
            }
        });

    });

});