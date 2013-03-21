var grid;

var columns = [
    {id: "date", name: "Date", field: "date",width:100},
    {id: "time_in", name: "Time In", field: "time_in",width:100},
    {id: "time_out", name: "Time Out", field: "time_out",width:100},
];

var options = {
    enableCellNavigation: true,
    enableColumnReorder: false
};

$(function () {
    var slickdata = [];
    var eid = $("#employee_id").val();
    $.getJSON("employee_hours/"+eid, function(data) {
	for (var i = 0; i < data.length; i++) {
	    slickdata[i] = {
		date : data[i].date,
		time_in : data[i].time_in,
		time_out : data[i].time_out
	    };

	}
    grid = new Slick.Grid("#emp_hour_table", slickdata, columns, options);
    });
})
