/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * =========================================================================
 * Investigation settings
 * =========================================================================
 * */

/* global DIAGNOSIS_URL, USER_ID, VISIT_ID, alertify,THE_PROCEDURE_URL */

$(function () {
    //mock hide this
    $('.instructions').hide();
    $('#doctor_form input,#doctor_form textarea,#nurse_form input,#nurse_form textarea').blur(function () {
        show_procedures_selected();
    });
    $('#in_procedures_table').dataTable({
        ajax: THE_PROCEDURE_URL,
        responsive: true
    });
    $('#doctor_form,#nurse_form').find('input:text').keyup(function () {
        show_procedures_selected();
    });
    $('input').on('ifChanged', function () {
        var elements = $(this).parents('tr').find('input');
        var texts = $(this).parents('tr').find('textarea');
        if ($(this).is(':checked')) {
            elements.prop('disabled', false);
            texts.prop('disabled', false);
            $(texts).parent().show();
        } else {
            elements.prop('disabled', true);
            texts.prop('disabled', true);
            $(texts).parent().hide();
        }
        $(this).prop('disabled', false);
        show_procedures_selected();
    });
    $('#nurse_form .check,#doctor_form .check').click(function () {
        var elements = $(this).parent().parent().find('input');
        var texts = $(this).parent().parent().find('textarea');
        if ($(this).is(':checked')) {
            elements.prop('disabled', false);
            texts.prop('disabled', false);
            $(texts).parent().show();
        } else {
            elements.prop('disabled', true);
            texts.prop('disabled', true);
            $(texts).parent().hide();
        }
        $(this).prop('disabled', false);
        show_procedures_selected();
    });

    function show_procedures_selected() {
        $('#show_selection').hide();
        $('#procedureInfo > tbody > tr').remove();
        var total = 0;
        $("#doctor_form,#nurse_form").find("input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#doctor_form,#nurse_form').find('#name' + procedure_id).html();
            var amount = john_doe(procedure_id);
            total += parseInt(amount);
            $('#procedureInfo > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
        });
        if (total) {
            $('#procedureInfo > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }
        $('#show_selection').show();
    }

    $('#saveProcedure').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: DIAGNOSIS_URL,
            data: $('#doctor_form, #nurse_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Patient procedure updated');
                $('#procedureTab').find('input').iCheck('uncheck');
                $('#in_procedures_table').dataTable().api().ajax.reload()
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Could not save procedure');
            }
        });
    });
    $('#doctor_form,#nurse_form')
        .find('input:radio, input:checkbox').prop('checked', false);
    $('#show_selection').hide();

    function john_doe(procedure_id) {
        function get_amount_given(price, qty, discount) {
            try {
                var total = price * qty;
                var d = total * (discount / 100);
                var discounted = total - d;
                return discounted;
            } catch (e) {
                return price;
            }
        }

        var cost = $('#cost' + procedure_id).val();
        var discount = $('#discount' + procedure_id).val();
        var quantity = $('#quantity' + procedure_id).val();
        var amount = get_amount_given(cost, quantity, discount);
        $('#amount' + procedure_id).val(amount);
        return amount;
    }
});