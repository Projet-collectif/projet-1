$(document).ready(function() {
    $('.datatable-blog tbody').on('click', '.details', function() {
        window.location = "/admin/blog/"+ parseInt($(this).parent("tr").attr("id")) +"/edit";
    });
});
