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

/* global DIAGNOSIS_URL, USER_ID, VISIT_ID, alertify */
$(function () {
    //mock hide this
    $('.instructions').hide();

    $('#radiology_form input,#radilogy_form textarea, #diagnosis_form input,#diagnosis_form textarea,#laboratory_form input,#laboratory_form textarea').blur(function () {
        show_selection_investigation();
    });
    $('#in_table').dataTable({
        ajax: THE_TABLE_URL,
        responsive: true
    });

    $('#diagnosis_form input:text').keyup(function () {
        show_selection_investigation();
    });

    $('#laboratory_form input:text').keyup(function () {
        show_selection_investigation();
    });

    $('#radiology_form input:text').keyup(function () {
        show_selection_investigation();
    });
    $('input').on('ifChanged', function (event) {
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
        show_selection_investigation();
    });

    $('#radiology_form .check,#laboratory_form .check,#diagnosis_form .check').click(function () {
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
        show_selection_investigation();
    });

    function show_selection_investigation() {
        $('#show_procedure_selection').hide();
        $('#diagnosisInfo > tbody > tr').remove();
        var total = 0;
        $("#diagnosis_form,#laboratory_form,#radiology_form").find("input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#diagnosis_form,#laboratory_form,#radiology_form').find('#name' + procedure_id).html();
            var amount = get_investigation_amount(procedure_id);
            total += parseInt(amount);
            $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
        });
        if (total) {
            $('#diagnosisInfo > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }
        $('#show_procedure_selection').show();
    }

    $('#saveInvestigations').click(function () {
        $.ajax({
            type: "POST",
            url: DIAGNOSIS_URL,
            data: $('#radiology_form,#diagnosis_form, #laboratory_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Patient investigation updated');
                $('#investigationTab').find('input').iCheck('uncheck');
                $('#in_table').dataTable().api().ajax.reload()
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Could not save investigation');
            }
        });
    });
    //sick of this
    $('#laboratory_form,#diagnosis_form,#radiology_form')
        .find('input:radio, input:checkbox').prop('checked', false);
    $('#show_procedure_selection').hide();


    function get_investigation_amount(procedure_id) {
        function get_amount_given(price, qty, discount) {
            try {
                var total = price * qty;
                var d = total * (discount / 100);
                return total - d;
            } catch (e) {
                return price;
            }
        }

        var the_forms = $('#diagnosis_form,#laboratory_form,#radiology_form');
        var cost = the_forms.find('#cost' + procedure_id).val();
        var discount = the_forms.find('#discount' + procedure_id).val();
        var quantity = the_forms.find('#quantity' + procedure_id).val();
        var amount = get_amount_given(cost, quantity, discount);
        the_forms.find('#amount' + procedure_id).val(amount);
        return amount;
    }
});