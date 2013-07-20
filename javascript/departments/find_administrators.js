var oTable;
$('.sorting_disabled').unbind('click');

jQuery.fn.dataTableExt.oSort['html-undefined']  = function(a,b) {
    return false;
};
$('.sorting_disabled').unbind('click');

$(document).ready(function() {
	oTable = $('#admins').dataTable({
		"bSortable": [],
		"bProcessing" : true,
		"sAjaxSource" : "/admins/all_admins",
		"aaSorting" : [ [ 2, "asc" ] ],
		"aoColumnDefs" : [ {
			"bVisible" : false,
			"aTargets" : [ 0 ]
		} ],
		"fnRowCallback" : function(nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function(event) {
				if ($(this).hasClass('row_selected')) {
					$(this).removeClass('row_selected');
					$("#aid").val("");
				} else {
					oTable.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
					$("#aid").val(aData[0]);
				}

			});

		}
	});
});

// Get the rows which are currently selected
function fnGetSelected(oTableLocal) {
	return oTableLocal.$('tr.row_selected');
}