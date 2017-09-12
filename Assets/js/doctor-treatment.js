/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * =========================================================================
 * Treatment URL
 * =========================================================================
 */
/* global TREAT_URL, VISIT_ID, USER_ID, DIAGNOSIS_URL, alertify */

$(function () {
    $('#treatment_form input:text').keyup(function () {
        show_selection($(this).attr('id'));
    });

    $('#treatment_form input').blur(function () {
        show_selection($(this).attr('id'));
    });

    $('#treatment_form .check').change(function () {
        var elements = $(this).parent().parent().find('input');
        if ($(this).is(':checked')) {
            elements.prop('disabled', false);
        } else {
            elements.prop('disabled', true);
        }
        $(this).prop('disabled', false);
        show_selection($(this).attr('id'));
    });

    function show_selection(field) {
        $('#selected_treatment').hide();
        $('#treatment > tbody > tr').remove();
        var total = 0;

        $("#treatment_form input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            if (field.includes('amount')) {
                var cost = $('#cost' + procedure_id).val();
                var quantity = $('#quantity' + procedure_id).val();
                var amount = $('#amount' + procedure_id).val();
                var total = cost * quantity;
                var discount = ((total - amount) * 100) / total;
                $('#discount' + procedure_id).val(discount);
                total += parseInt(amount);
                $('#treatment > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
            } else {
                var amount = john_doe(procedure_id);
                total += parseInt(amount);
                $('#treatment > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
            }
        });

        if (total) {
            $('#treatment > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }
        $('#selected_treatment').show();
        //  save_treatment();
    }
    $('#saveTreatment').click(function (e) {
        e.preventDefault();
        save_treatment();
    });
    function save_treatment() {
        $.ajax({
            type: "POST",
            url: DIAGNOSIS_URL,
            data: $('#treatment_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Selected treatment procedures saved');
                location.reload();
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Something wrong happened, Retry');
            }});
        //  $('#selected_treatment').hide();
        //
    }

    function john_doe(procedure_id) {
        var cost = $('#cost' + procedure_id).val();
        var discount = $('#discount' + procedure_id).val();
        var quantity = $('#quantity' + procedure_id).val();
        var amount = get_amount_given(cost, quantity, discount);
        $('#amount' + procedure_id).val(amount);
        return amount;
    }

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
    $('#treatment_form').find('input:radio, input:checkbox').prop('checked', false);
    $('#selected_treatment').hide();

});