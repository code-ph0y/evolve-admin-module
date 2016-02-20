$(document).ready(function() {
    $('#data-table').DataTable();

    $('#check-all').on('click', function(e) {
        if ($(e.target).is(':checked')) {
            $('.check-boxes').prop('checked', 'checked');
        } else {
            $('.check-boxes').prop('checked', '');
        }
    });
});
