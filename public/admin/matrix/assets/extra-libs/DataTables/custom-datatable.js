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
    controller = $('#datatable').attr('data-controller');
    _local = $('html').attr('lang');
    $('.datatable-'+controller+' tbody').on('click', '.details', function() {
        window.location = '/'+_local+'/admin/'+controller+'/edit/'+parseInt($(this).parent('tr').attr('id'));
    });
    $('.datatable-'+controller+' tbody').on('click', '.fa-check', function() {
        id = $(this).attr("data-id");
        _ajax(id, 'false', controller, function(data) {
            if (data == true) {
                $('#valid-'+id).removeClass('fa-check').addClass('fa-times');
            }
        });
    });
    $('.datatable-'+controller+' tbody').on('click', '.fa-times', function() {
        id = $(this).attr('data-id');
        _ajax(id, 'true', controller, function(data) {
            if (data == true) {
                $('#valid-'+id).removeClass('fa-times').addClass('fa-check');
            }
        });
    });
});
function _ajax(id, action, controller, callback) {
    $.ajax({ 
        type: 'POST', 
        url: '/'+$('html').attr('lang')+'/admin/'+controller+'/publish/ajax', 
        data: {'id': id, 'action': action},
        async: true,
        success: function(data)
        { 
            callback.call(this, data);
        } 
    });
}