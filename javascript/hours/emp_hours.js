$(document).ready(function() {
	$('#dataTable').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/hours/employee_hours"
	});
});