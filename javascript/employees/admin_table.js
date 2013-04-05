$(document).ready(function() {

	$('#all_employees').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/employees/all_employees"
	});
});