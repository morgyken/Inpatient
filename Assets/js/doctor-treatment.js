/*
 * =========================================================================
 * Treatment URL
 * =========================================================================
 */
/* global TREAT_URL, VISIT_ID, USER_ID, DIAGNOSIS_URL, alertify */

$(function () {
    $('#proceduresLoader').hide();
    $('.treatment_item').find('table').DataTable({
        "scrollY": "300px",
        "paging": false
    });
    if (typeof  PERFOMED_URL !== 'undefined') {
        $('#in_table').dataTable({
            ajax: PERFOMED_URL
        });
    }
    $('#procedures_doctor_form,#procedures_nurse_form').find('input:text').keyup(function () {
        preview_treatment_selection();
    });

    $('#procedures_doctor_form,#procedures_nurse_form').find('input').blur(function () {
        preview_treatment_selection();
    });

    $('#procedures_doctor_form,#procedures_nurse_form').find('input').on('ifChanged', function () {
        var elements = $(this).parents('tr').find('input,textarea');
        var procedure_id = $(this).val();
        if ($(this).is(':checked')) {
            elements.prop('disabled', false);
            var name = $('#name' + procedure_id).html();
            var amount = john_doe(procedure_id);
            addOrReplaceTreatment({
                id: procedure_id,
                name: name,
                amount: amount
            });
        } else {
            elements.prop('disabled', true);
            removeTheTreatment(procedure_id);
        }
        $(this).prop('disabled', false);
        preview_treatment_selection();
    });

    function preview_treatment_selection() {
        $('#selected_treatment').hide();
        $('#treatment > tbody > tr').remove();
        var total = 0;
        treatmentInvestigations.forEach(function (data) {
            var name = data.name;
            var amount = john_doe(data.id);
            total += parseInt(amount);
            $('#treatment > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
        });
        if (total) {
            $('#treatment > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }
        $('#selected_treatment').show();
    }

    var treatmentInvestigations = [], trIndex = {};
    var position = 0;

    function addOrReplaceTreatment(object) {
        var index = trIndex[object.id];
        if (index === undefined) {
            index = position;
            trIndex[object.id] = index;
            position++;
        }
        treatmentInvestigations[index] = object;
    }

    function removeTheTreatment(id) {
        treatmentInvestigations = treatmentInvestigations.filter(function (obj) {
            return obj.id !== id;
        });
    }

    $('#saveTreatment').click(function (e) {
        e.preventDefault();
        save_treatment();
    });
    $('#in_table').on('click', '#sapi_del', function () {
        $to_post = $(this).attr('to');
        swal({
            title: "Are you sure?",
            text: "The procedure will be deleted only if it hasn't been paid/billed",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: $to_post,
                    type: 'DELETE',
                    data: {_token: $("meta[name=token]").attr("content")},
                    success: function () {
                        alertify.success("Deleted");
                        $('#in_table').dataTable().api().ajax.reload();
                    }
                })
            }
        });
    });

    function save_treatment() {
        var $btn = $('button#saveTreatment');
        $.ajax({
            type: "POST",
            url: DIAGNOSIS_URL,
            beforeSend: function () {
                $btn.hide();
                $('#proceduresLoader').show();
            },
            data: $('#procedures_doctor_form,#procedures_nurse_form').serialize(),
            success: function () {
                $('#proceduresLoader').hide();
                alertify.success('<i class="fa fa-check-circle"></i> Selected treatment procedures saved');
                $('.treatment_item').find('input').iCheck('uncheck');
                $('#in_table').dataTable().api().ajax.reload();
                treatmentInvestigations = [];
                trIndex = {};
                preview_treatment_selection();
                $btn.show();
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Something wrong happened, Retry');
                $('#proceduresLoader').hide();
                $btn.show();
            }
        });
        //  $('#selected_treatment').hide();
        //
    }

    function john_doe(procedure_id) {
        var cost = $('#cost' + procedure_id).val();
        // var discount = $('#discount' + procedure_id).val();
        var quantity = $('#quantity' + procedure_id).val();
        var amount = get_amount_given(cost, quantity, 0);
        $('#amount' + procedure_id).val(amount);
        return amount;
    }

    function get_amount_given(price, qty, discount) {
        try {
            var total = price * qty;
            var d = total * (discount / 100);
            return total - d;
        } catch (e) {
            return price;
        }
    }

    $('#treatment_form').find('input:radio, input:checkbox').prop('checked', false);
    $('#selected_treatment').hide();

});