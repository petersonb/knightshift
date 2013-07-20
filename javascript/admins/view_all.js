$(document).ready(function() {
	$('#dataTable').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/admins/get_all",
		"aaSorting" : [[$("#sortCol").val(),"asc"]]
	});
});