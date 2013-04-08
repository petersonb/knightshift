$(document).ready(function() {

	$('#all_employees').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/employees/department_employees",
		"aaSorting" : [[1,"asc"]]
	});
});