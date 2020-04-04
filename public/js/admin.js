$(document).ready(function () {

    var table = $('#dataTable').DataTable({
        "paging": false
    });
    var itemsCount = table.rows().count();


    $("#addRow").on('click', function (e) {
        itemsCount++;
        table.row.add([
            `<input type="text" class="form-control border-0 shadow-none" placeholder="Key" name="translation[key][${itemsCount}]" value="">`,
            `<input type="text" class="form-control border-0 shadow-none" placeholder="Value" name="translation[value][${itemsCount}]" value="">`
        ]).draw(false)
    });

    if (itemsCount == 0) {
        $('#addRow').click();
    }
});