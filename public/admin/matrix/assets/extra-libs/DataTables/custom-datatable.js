$(document).ready(function() {
    $('#datatable').DataTable({
        language: {
            url: "/admin/matrix/assets/extra-libs/DataTables/language/datatable.french.json"
        },
        lengthMenu:[10,15,20,25,50,75,100],
        pagingType: "simple_numbers",
        order: [
            [ 1, "asc" ]
        ],
        aoColumnDefs: [ 
            { 'bSortable': false, 'aTargets': [ 0 ] } 
        ]
    });
});