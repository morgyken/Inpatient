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
    $('#diagnosisLoader').hide();
    $('.investigation_item').find('table#di,table#rad').DataTable({
        scrollY: "300px",
        paging: false
    });
    if (typeof  PERFOMED_INVESTIGATION_URL !== 'undefined') {
        $('#previousInvestigations').dataTable({
            ajax: PERFOMED_INVESTIGATION_URL
        });
    }
    $('#previousInvestigations').on('click', '#sapi_del', function () {
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
                        $('#previousInvestigations').dataTable().api().ajax.reload();
                    }
                })
            }
        });
    });
    $('#radiology_form input,#radiology_form textarea, #diagnosis_form input,#diagnosis_form textarea,#laboratory_form input,#laboratory_form textarea').blur(function () {
        show_selection_investigation();
    });

    $('#diagnosis_form,#laboratory_form,#radiology_form ').find('input:text').keyup(function () {
        show_selection_investigation();
    });
    var investigationForms = $('#radiology_form,#laboratory_form,#diagnosis_form');
    investigationForms.find('input').on('ifChanged', function () {
        var elements = $(this).parents('tr').find('input');
        var texts = $(this).parents('tr').find('textarea');
        var procedure_id = $(this).val();
        if ($(this).is(':checked')) {
            elements.prop('disabled', false);
            texts.prop('disabled', false);
            $(texts).parent().show();
            var name = $('#name' + procedure_id).html();
            var amount = get_total_for_investigation(procedure_id);
            addOrReplaceInvestigation({
                id: procedure_id,
                name: name,
                amount: amount
            });
        } else {
            elements.prop('disabled', true);
            texts.prop('disabled', true);
            $(texts).parent().hide();
            removeTheInvestigation(procedure_id);
        }
        $(this).prop('disabled', false);
        show_selection_investigation();
    });
    $(document).on('change', '#radiology_form  input,#laboratory_form  input,#diagnosis_form input', function () {
        var elements = $(this).parents('tr').find('input');
        var texts = $(this).parents('tr').find('textarea');
        var procedure_id = $(this).val();
        if ($(this).is(':checked')) {
            elements.prop('disabled', false);
            texts.prop('disabled', false);
            // $(texts).parent().show();
            var name = $('#name' + procedure_id).html();
            var amount = get_total_for_investigation(procedure_id);
            addOrReplaceInvestigation({
                id: procedure_id,
                name: name,
                // qty: $('#quantity' + procedure_id).val(),
                // price: $('#price' + procedure_id).val(),
                amount: amount
            });
        } else {
            elements.prop('disabled', true);
            texts.prop('disabled', true);
            $(texts).parent().hide();
            removeTheInvestigation(procedure_id);
        }
        $(this).prop('disabled', false);
        show_selection_investigation();
    });

    function show_selection_investigation() {
        $('#show_selection').hide();
        $('#diagnosisInfo > tbody > tr').remove();
        var total = 0;
        procedureInvestigations.forEach(function (data) {
            var name = data.name;
            var amount = get_total_for_investigation(data.id);
            total += parseInt(amount);
            $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
        });
        if (total) {
            $('#diagnosisInfo > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }
        $('#show_selection').show();
    }

    var procedureInvestigations = [], arrIndex = {};
    var position = 0;

    function addOrReplaceInvestigation(object) {
        var index = arrIndex[object.id];
        if (index === undefined) {
            index = position;
            arrIndex[object.id] = index;
            position++;
        }
        procedureInvestigations[index] = object;
    }

    function removeTheInvestigation(id) {
        procedureInvestigations = procedureInvestigations.filter(function (obj) {
            return obj.id !== id;
        });
    }

    $('#saveDiagnosis').click(function (e) {
        e.preventDefault();
        var $btn = $('button#saveDiagnosis');
        $.ajax({
            type: "POST",
            url: DIAGNOSIS_URL,
            // data: JSON.stringify(procedureInvestigations),// $('#radiology_form,#diagnosis_form, #laboratory_form').serialize(),
            data: $('#radiology_form,#diagnosis_form, #laboratory_form').serialize(),
            beforeSend: function () {
                $btn.hide();
                $('#diagnosisLoader').show();
            },
            success: function () {
                $btn.show();
                $('#diagnosisLoader').hide();
                alertify.success('<i class="fa fa-check-circle"></i> Patient evaluation updated');
                // $('.investigation_item').find('input').iCheck('uncheck');
                $('input[type=checkbox]').prop('checked', false).trigger('change');
                procedureInvestigations = [];
                arrIndex = {};
                position = 0;
                $('#previousInvestigations').dataTable().api().ajax.reload();
                show_selection_investigation();
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Could not save evaluation');
                $btn.show();
                $('#diagnosisLoader').hide();
            }
        });
        //location.reload();
    });
    $('.investigation_item').find('input').iCheck('uncheck');
    $('#show_selection').hide();

    function get_amount_given(price, qty, discount) {
        try {
            var total = price * qty;
            var d = total * (discount / 100);
            return total - d;
        } catch (e) {
            return price;
        }
    }

    function get_total_for_investigation(procedure_id) {
        var cost = $('#cost' + procedure_id).val();
        var discount = $('#discount' + procedure_id).val();
        var quantity = $('#quantity' + procedure_id).val();
        var amount = get_amount_given(cost, quantity, discount);
        $('#amount' + procedure_id).val(amount);
        return amount;
    }
});