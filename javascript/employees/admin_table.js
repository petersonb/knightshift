$(document).ready(function() {

	$('#all_employees').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/employees/all_employees",
		"aaSorting" : [[1,"asc"]]
	});
});