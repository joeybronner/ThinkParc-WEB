/**
 * vehiclesoverview.js
 *
 * @see vehiclesoverview.php
 * @author Joey Bronner
 * @version 1.0
 */
 
/** Global public variables used and re-used in some methods */
var data_charts2;
var data_charts3;
var data_charts4;
var data_charts5;
var days_maintenance = 0;
var days_available = 0;
google.load("visualization", "1", {
    packages: ["corechart"]
});
google.setOnLoadCallback(drawChart);

/** Method called on page loading */
$(function onLoad() {
    document.getElementById("chart1").style.display = "none";
    getAllVehicles();
    $('#date_start').datepicker();
    $('#date_end').datepicker();
});

/** Refreshes all reports */
function refreshReport() {
    var sum_parts = 0;
    document.getElementById("chart1").style.display = "block";
    var id_vehicle = document.getElementById("listvehicles").value;
    var date_start = document.getElementById("date_start").value.split("/").reverse().join("-");
    var date_end = document.getElementById("date_end").value.split("/").reverse().join("-");
    var filter = document.getElementById("filter").value;
    getCompany(function(company) {
        // Chart for part consumption (maintenance)
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehicle/" + id_vehicle + "/daysmaintenance",
            success: function(data) {
                var response = JSON.parse(data);
                var maintenancedays;
                if (response[0].maintenancedays == null) {
                    maintenancedays = 0;
                } else {
                    maintenancedays = response[0].maintenancedays;
                }
                $.ajax({
                    method: "GET",
                    url: "http://think-parc.com/webservice/v1/companies/vehicles/" + id_vehicle,
                    success: function(data) {
                        var responsevehicle = JSON.parse(data);
                        var date_buy = new Date(responsevehicle[0].date_buy);
                        var date_now = new Date(new Date().yyyymmdd());
                        days_maintenance = parseInt(maintenancedays);
                        days_available = parseInt(((date_now - date_buy) / 86400000) - days_maintenance);

                        drawChart();
                    },
                    async: false
                });
            },
            async: false
        });
        // Chart of Reference / Qty used
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/vehicles/usedparts/" + id_vehicle + "/" + date_start + "/" + date_end,
            success: function(data) {
                var response = JSON.parse(data);
                data_charts2 = new Array(response.length + 1);
                data_charts2[0] = new Array("Reference", "Quantity");
                for (var i = 1; i <= response.length; i++) {
                    data_charts2[i] = new Array(response[i - 1].reference,
                        parseInt(response[i - 1].qt)
                    );
                }
                drawChart2();
            },
            async: false
        });
        // Chart of type of maintenance
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/vehicles/typemaintenance/" + id_vehicle + "/" + date_start + "/" + date_end,
            success: function(data) {
                var response = JSON.parse(data);
                data_charts3 = new Array(response.length + 1);
                data_charts3[0] = new Array("Type of maintenance", "Quantity");
                for (var i = 1; i <= response.length; i++) {
                    var qt = 0;
                    if (response[i - 1].cancelnull > 0) {
                        qt = parseInt(response[i - 1].sumtm);
                    }
                    data_charts3[i] = new Array(response[i - 1].typemaintenance,
                        qt
                    );
                }
                drawChart3();
            },
            async: false
        });
        // Maintenance cost
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/maintenance/cost/" + id_vehicle + "/start/" + date_start + "/end/" + date_end + "/filter/" + filter,
            success: function(data) {
                var response = JSON.parse(data);
                data_charts4 = new Array(response.length + 1);
                data_charts4[0] = new Array("Cost", "€", {
                    role: "style"
                });
                for (var i = 1; i <= response.length; i++) {
                    var col_name;
                    if (filter == "DAY") {
                        col_name = reformatDate(response[i - 1].f);
                    } else if (filter == "MONTH") {
                        col_name = response[i - 1].f + "/" + response[i - 1].y;
                    } else if (filter == "YEAR") {
                        col_name = response[i - 1].y;
                    }
                    data_charts4[i] = new Array(col_name,
                        parseInt(response[i - 1].maintcost),
                        "#3366cc");
                }
                drawChart4();
            },
            async: false
        });
        // Maintenance parts
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/maintenance/parts/" + id_vehicle + "/start/" + date_start + "/end/" + date_end + "/filter/" + filter,
            success: function(data) {
                var response = JSON.parse(data);
                data_charts5 = new Array(response.length + 1);
                data_charts5[0] = new Array("Parts", "Unit", {
                    role: "style"
                });
                for (var i = 1; i <= response.length; i++) {
                    var col_name;
                    if (filter == "DAY") {
                        col_name = reformatDate(response[i - 1].f);
                    } else if (filter == "MONTH") {
                        col_name = response[i - 1].f + "/" + response[i - 1].y;
                    } else if (filter == "YEAR") {
                        col_name = response[i - 1].y;
                    }
                    data_charts5[i] = new Array(col_name,
                        parseInt(response[i - 1].maintparts),
                        "#FFCC00");
                }
                drawChart5();
            },
            async: false
        });
    });
}

/** Draws chart for maintenance count (days availble/maintenance) */
function drawChart() {
    var data;
    data = google.visualization.arrayToDataTable([
        ['Available', 'Maintenance'],
        ['Available', days_available],
        ['Maintenance', days_maintenance]
    ]);

    var options = {
        title: "Available vs Maintenance (global)",
        backgroundColor: {
            fill: 'transparent'
        },
        pieHole: 0.4,
        titleTextStyle: {
            color: '#FFF',
            fontSize: 16,
            fontStyle: "normal"
        },
        legendTextStyle: {
            color: '#FFF'
        },
        colors: ['#009933', "#990000"]
    };

    var chart = new google.visualization.PieChart(document.getElementById('availablemaintenancedays'));
    chart.draw(data, options);

}

/** Draws chart for quantity used by reference */
function drawChart2() {
    var data;
    if (typeof(data_charts2) != "undefined" && data_charts2.length > 1) {
        data = google.visualization.arrayToDataTable(data_charts2);
    } else {
        data = google.visualization.arrayToDataTable([
            ['Reference', 'Quantity'],
            ['No values', 1]
        ]);
    }

    var options = {
        title: "Used parts",
        backgroundColor: {
            fill: 'transparent'
        },
        pieHole: 0.4,
        titleTextStyle: {
            fontSize: 16,
            fontStyle: "normal",
            color: '#FFF'
        },
        legendTextStyle: {
            color: '#FFF'
        }
    };

    var chart = new google.visualization.PieChart(document.getElementById('partsused'));
    chart.draw(data, options);

}

/** Draws chart for type of maintenance */
function drawChart3() {
    var data;
	var empty=0;
	for (var i=1 ; i<data_charts3.length ; i++) {
		var arr = data_charts3[i];
		if (parseInt(arr[1]) > 0) {
			empty=1;
		}
	}
	
    if (typeof(data_charts3) != "undefined" && empty == 1) {
        data = google.visualization.arrayToDataTable(data_charts3);
    } else {
        data = google.visualization.arrayToDataTable([
            ['Type', 'Quantity'],
            ['No values', 1]
        ]);
    }

    var options = {
        title: "Type of maintenance",
        backgroundColor: {
            fill: 'transparent'
        },
        pieHole: 0.4,
        titleTextStyle: {
            fontSize: 16,
            fontStyle: "normal",
            color: '#FFF'
        },
        legendTextStyle: {
            color: '#FFF'
        },
        colors: ['#E6ED5A', "#BF8273", "#A873BF", "#8ABF73"]
    };

    var chart = new google.visualization.PieChart(document.getElementById('typemaintenance'));
    chart.draw(data, options);

}

/** Draws chart for data_charts4 values */
function drawChart4() {
    if (typeof(data_charts4) != "undefined") {
        var data = google.visualization.arrayToDataTable(data_charts4);
        var optionsData = {
            backgroundColor: {
                fill: 'transparent'
            },
            titleTextStyle: {
                color: '#FFF'
            },
            legendTextStyle: {
                color: '#FFF'
            },
            vAxis: {
                textStyle: {
                    color: '#FFF'
                }
            },
            hAxis: {
                textStyle: {
                    color: '#FFF'
                }
            },
            legend: {
                position: "right"
            },
        };
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1, {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        }, 2]);
        var optionsView = {
            title: "Maintenance cost",
            backgroundColor: {
                fill: 'transparent'
            },
            titleTextStyle: {
                fontSize: 16,
                fontStyle: "normal",
                color: '#FFF'
            },
            legendTextStyle: {
                color: '#FFF'
            },
            bar: {
                groupWidth: "95%"
            },
            vAxis: {
                textStyle: {
                    color: '#FFF'
                }
            },
            hAxis: {
                textStyle: {
                    color: '#FFF'
                }
            },
            legend: {
                position: "right"
            },
            animation: {
                duration: 1000,
                easing: 'in'
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("maintenancecost"));
        chart.draw(data, optionsData); // 1st draw with data (animate)
        chart.draw(view, optionsView); // 2nd draw with data & view
    }
}

/** Draws chart for data_charts5 values */
function drawChart5() {
    if (typeof(data_charts5) != "undefined") {
        var data = google.visualization.arrayToDataTable(data_charts5);
        var optionsData = {
            backgroundColor: {
                fill: 'transparent'
            },
            titleTextStyle: {
                color: '#FFF'
            },
            legendTextStyle: {
                color: '#FFF'
            },
            vAxis: {
                textStyle: {
                    color: '#FFF'
                }
            },
            hAxis: {
                textStyle: {
                    color: '#FFF'
                }
            },
            legend: {
                position: "right"
            },
        };
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1, {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        }, 2]);
        var optionsView = {
            title: "Maintenance parts",
            backgroundColor: {
                fill: 'transparent'
            },
            titleTextStyle: {
                fontSize: 16,
                fontStyle: "normal",
                color: '#FFF'
            },
            legendTextStyle: {
                color: '#FFF'
            },
            bar: {
                groupWidth: "95%"
            },
            vAxis: {
                textStyle: {
                    color: '#FFF'
                }
            },
            hAxis: {
                textStyle: {
                    color: '#FFF'
                }
            },
            legend: {
                position: "right"
            },
            animation: {
                duration: 1000,
                easing: 'in'
            },
			colors: ['#FFCC00']
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("maintenanceparts"));
        chart.draw(data, optionsData); // 1st draw with data (animate)
        chart.draw(view, optionsView); // 2nd draw with data & view
    }
}

/** Retrieves Company's ID */
function getCompany(handleData) {
    var id_user = document.getElementById('fct_id_user').innerHTML;
    $.ajax({
        method: "GET",
        url: "http://think-parc.com/webservice/v1/companies/users/" + id_user,
        success: function(data) {
            var response = JSON.parse(data);
            handleData(response[0].id_company);
        }
    });
};
/** Retrieves all vehicles */
function getAllVehicles() {
    getCompany(function(company) {
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/all",
            success: function(data) {
                var response = JSON.parse(data);
                var content = '';
                var contenttable = '';
                for (var i = 0; i < response.length; i++) {
                    content = content + '<option value="' + response[i].id_vehicle + '">' + response[i].nr_plate + '</option>';
                }
                document.getElementById("listvehicles").innerHTML = content;
            }
        });
    });
};

/** Good date format JJ/MM/AAAA */
function reformatDate(dateStr) {
    dArr = dateStr.split("-");
    return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
}
/** Date prototype JJ/MM/AAAA */
Date.prototype.yyyymmdd = function() {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString();
    var dd = this.getDate().toString();
    return yyyy + '-' + (mm[1] ? mm : "0" + mm[0]) + '-' + (dd[1] ? dd : "0" + dd[0]);
};