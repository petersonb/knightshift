$(document).ready(function() {
	$('#todays_shifts').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/shifts/todays_shifts",
		"aaSorting" : [[2,"asc"]]
	});
});
