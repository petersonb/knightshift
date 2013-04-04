var grid;


var columns = [
    {id: "date", name: "Date", field: "date",width:100, sortable : true},
    {id: "time_in", name: "Time In", field: "time_in",width:100},
    {id: "time_out", name: "Time Out", field: "time_out",width:100},
];

var options = {
    enableCellNavigation: true,
    enableColumnReorder: false
};

var sortcol = "date"

function compareDates(d1,d2) {
    var x = d1.date, y = d2.date;

    if (x==y)
    {
	return 0;
    }

    splitx = x.split('/');
    splity = y.split('/');

    var xy = splitx[2], yy = splity[2];

    if (xy > yy)
    {
	return 1;
    }
    else if (xy < yy)
    {
	return -1;
    }

    var xm = splitx[0], ym = splity[0];

    if (xm > ym)
    {
	return 1;
    }
    else if (xm < ym)
    {
	return -1;
    }

    var xd = splitx[1], yd = splity[1];

    if (xd > yd)
    {
	return 1;
    }
    
    
    else if (xd < yd)
    {
	return -1;
    }
    console.log('miss');
}

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
	console.log(slickdata);
	slickdata.sort(compareDates,"date");
	console.log(slickdata);
	grid = new Slick.Grid("#emp_hour_table", slickdata, columns, options);
    });
})

