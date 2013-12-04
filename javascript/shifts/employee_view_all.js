$(document).ready(function() {
	$('#all_shifts').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/shifts/employee_today_shifts",
		"aaSorting" : [[2,"asc"]]
	});
});
