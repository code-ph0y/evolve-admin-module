$(document).ready(function() {
	$('.block-user').on('click', function() {
		BootstrapDialog.show({
			title: 'Confirmation',
			message: 'Are you sure you want to block user?',
			closable: false,
            buttons: [{
                label: 'Yes',
                cssClass: 'btn-success',
                action: function(dialogRef) {
                    //dialogRef.setClosable(true);
                }
            }, {
                label: 'No',
                cssClass: 'btn-warning',
                action: function(dialogRef) {
					dialogRef.close();
                }
            }]
		});
	});
});
