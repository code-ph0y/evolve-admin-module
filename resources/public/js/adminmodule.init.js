$(document).ready(function() {
	$('#block-user').on('click', function() {
		BootstrapDialog.show({
			title: 'Say-hello dialog',
			message: 'Hi Apple!'
		});
	});
});
