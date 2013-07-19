$(document).ready(function() {
	$('#dataTable').dataTable({
		"bProcessing" : true,
		"sAjaxSource" : "/admins/get_all_admins",
		"aaSorting" : [[$("#sortCol").val(),"asc"]]
	});
});