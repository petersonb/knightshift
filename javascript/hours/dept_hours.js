$(document).ready(function() {

	$('#dataTable').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/hours/department_hours",
		"aaSorting" :  [[1,"desc"]]
	});
});