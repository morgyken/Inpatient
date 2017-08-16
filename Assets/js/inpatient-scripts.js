function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
}

$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);

var temp_ctx = $("#temp_chart");

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