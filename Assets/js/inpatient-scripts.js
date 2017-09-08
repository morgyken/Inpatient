function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
}

$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);
// var myLineChart = new Chart(temp_ctx, {
//     type: 'line',
//     data: [0,10,20,15,4],
//     options: {
//         elements: {
//             line: {
//                 tension: 0, // disables bezier curves
//             }
//         }
//     }
// });

$(document).ready(function () {
    var i = 3;
    $("#add_row").click(function () {
        var to_add = "<td><select name=\"item" + i + "\"  id=\"item_" + i + "\" class=\" select2-single\" style=\"width: 100%\"></select></td><td><input type=\"text\" name='qty" + i + "' id='item_qty_" + i + "'  placeholder='Quantity' value=\"0\" class=\"quantities\"/><input type='hidden' name='batch" + i + "'><span id='fb" + i + "'></span></td><td><input type=\"text\" name='price" + i + "' placeholder='Price'/></td> <td><input type=\"text\" name='dis" + i + "' placeholder='Discount' value=\"0\"/></td></td><td><span id=\"total" + i + "\">0.00</span></td><td><button class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></button></td>";
        $('#addr' + i).html(to_add);
        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        map_select2(i);
        i++;
    });

    function map_select2(i) {
        //$('#addr' + i + ' select').select2({
        $('#item_' + i).select2({
            "theme": "classic",
            "placeholder": 'Please select an item',
            "formatNoMatches": function () {
                return "No matches found";
            },
            "formatInputTooShort": function (input, min) {
                return "Please enter " + (min - input.length) + " more characters";
            },
            "formatInputTooLong": function (input, max) {
                return "Please enter " + (input.length - max) + " less characters";
            },
            "formatSelectionTooBig": function (limit) {
                return "You can only select " + limit + " items";
            },
            "formatLoadMore": function (pageNumber) {
                return "Loading more results...";
            },
            "formatSearching": function () {
                return "Searching...";
            },
            "minimumInputLength": 2,
            "allowClear": true,
            "ajax": {
                "url": PRODUCTS_URL,
                "dataType": "json",
                "cache": true,
                "data": function (term, page) {
                    return {
                        term: term
                    };
                },
                "results": function (data, page) {
                    return {results: data};
                }
            }
        });
    }

    

});