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

/* global DIAGNOSIS_URL, USER_ID, VISIT_ID, alertify,THE_consumable_URL */

$(function () {
    //mock hide this
    $('.instructions').hide();
    $('#consumable_forminput,#consumable_formtextarea,#nurse_form input,#nurse_form textarea').blur(function () {
        show_consumables_selected();
    });
    $('#in_consumables_table').dataTable({
        ajax: THE_CONSUMABLE_URL,
        responsive: true
    });
    $('#consumable_form').find('input:text').keyup(function () {
        show_consumables_selected();
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
        show_consumables_selected();
    });
    $('#consumable_form.check').click(function () {
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
        show_consumables_selected();
    });

    function show_consumables_selected() {
        $('#show_consumable_selection').hide();
        $('#consumableInfo > tbody > tr').remove();
        var total = 0;
        $("#consumable_form").find("input:checkbox:checked").each(function () {
            var consumable_id = $(this).val();
            var name = $('#name' + consumable_id).html();
            var amount = john_doe(consumable_id);
            total += parseInt(amount);
            $('#consumableInfo > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
        });
        if (total) {
            $('#consumableInfo > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }
        $('#show_consumable_selection').show();
    }

    $('#saveConsumable').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: DIAGNOSIS_URL,
            data: $('#doctor_form, #nurse_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Patient consumable updated');
                $('#consumableTab').find('input').iCheck('uncheck');
                $('#in_consumables_table').dataTable().api().ajax.reload()
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Could not save consumable');
            }
        });
    });
    $('#doctor_form,#nurse_form')
        .find('input:radio, input:checkbox').prop('checked', false);
    $('#show_consumable_selection').hide();

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

    function john_doe(consumable_id) {
        var cost = $('#cost' + consumable_id).val();
        var discount = $('#discount' + consumable_id).val();
        var quantity = $('#quantity' + consumable_id).val();
        var amount = get_amount_given(cost, quantity, discount);
        $('#amount' + consumable_id).val(amount);
        return amount;
    }
});