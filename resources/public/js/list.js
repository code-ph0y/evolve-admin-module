$(document).ready(function() {
    $('#check-all').on('click', function(e) {
        if ($(e.target).is(':checked')) {
            $('.check-boxes').prop('checked', true);
            $('#btn-delete-selected').prop('disabled', false);
            $
        } else {
            $('.check-boxes').prop('checked', false);
            $('#btn-delete-selected').prop('disabled', true);
        }
    });

    $('.check-boxes').on('click', function() {
        checked = $('.check-boxes:checkbox:checked');

        if (checked.length > 0) {
            $('#btn-delete-selected').prop('disabled', false);
        } else {
            $('#btn-delete-selected').prop('disabled', true);
        }

        if ($('.check-boxes').length == checked.length) {
            $('#check-all').prop('checked', true);
        } else {
            $('#check-all').prop('checked', false);
        }
    });

    $('#btn-delete-selected').on('click', function(event) {
        event.preventDefault();
        $('#delete-items').val(generateIdsFromCheckboxes());
        $('#delete-form').submit();
    });
});


function generateIdsFromCheckboxes() {
    checked = $('.check-boxes:checkbox:checked');
    itemsString = '';

    for(i = 0; i < checked.length; i++) {
        itemsString += $(checked[i]).val();
        if (i != checked.length - 1) {
            itemsString += ',';
        }
    }

    return itemsString;
}
