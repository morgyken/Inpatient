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

/* global DIAGNOSIS_URL, USER_ID, VISIT_ID, alertify,CONSUMABLE_URL*/

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
    $('#consumable_form').find('input').on('ifChanged', function () {
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

    function show_consumables_selected() {
        $('#show_consumable_selection').hide();
        $('#consumableInfo > tbody > tr').remove();
        var total = 0;
        $("#consumable_form").find("input:checkbox:checked").each(function () {
            var consumable_id = $(this).val();
            var name = $('#consumable_form').find('#name' + consumable_id).html();
            var amount = get_item_amount(consumable_id);
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
            url: CONSUMABLE_URL,
            data: $('#consumable_form').serialize(),
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
    $('#consumable_form')
        .find('input:radio, input:checkbox').prop('checked', false);
    $('#show_consumable_selection').hide();

    function get_item_amount(consumable_id) {

        function get_amount_given(price, qty, discount) {
            try {
                var total = price * qty;
                var d = total * (discount / 100);
                return total - d;
            } catch (e) {
                return price;
            }
        }

        var $myforms = $('#consumable_form');
        var cost = $myforms.find('#cost' + consumable_id).val();
        var discount = $myforms.find('#discount' + consumable_id).val();
        var quantity = $myforms.find('#quantity' + consumable_id).val();
        var amount = get_amount_given(cost, quantity, discount);
        $myforms.find('#amount' + consumable_id).val(amount);
        return amount;
    }
});