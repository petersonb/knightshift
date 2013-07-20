var oTable;
$('.sorting_disabled').unbind('click');

jQuery.fn.dataTableExt.oSort['html-undefined']  = function(a,b) {
    return false;
};
$('.sorting_disabled').unbind('click');

$(document).ready(function() {
	oTable = $('#employees').dataTable({
		"bSortable": [],
		"bProcessing" : true,
		"sAjaxSource" : "/departments/all_unrelated_employees",
		"aaSorting" : [ [ 2, "asc" ] ],
		"aoColumnDefs" : [ {
			"bVisible" : false,
			"aTargets" : [ 0 ]
		} ],
		"fnRowCallback" : function(nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function(event) {
				if ($(this).hasClass('row_selected')) {
					$(this).removeClass('row_selected');
					$("#eid").val("");
				} else {
					oTable.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
					$("#eid").val(aData[0]);
				}

			});

		}
	});
});

// Get the rows which are currently selected
function fnGetSelected(oTableLocal) {
	return oTableLocal.$('tr.row_selected');
}