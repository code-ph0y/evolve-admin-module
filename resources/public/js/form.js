$(document).ready(function() {
	$('.btn-cancel').click(function() {
		parent.history.back();
		return false;
	});
});
