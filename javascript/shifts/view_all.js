$(document).ready(function() {
	$('#all_shifts').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/shifts/department_shifts",
		"aaSorting" : [[2,"asc"]]
	});
});
