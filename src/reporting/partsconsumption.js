/**
 * partsconsumption.js
 *
 * @see partsconsumption.php
 * @author Joey Bronner
 * @version 1.0
 */

/** Global public variables used and re-used in some methods */
var data_charts1;
var data_charts3;
var data_charts6;
google.load("visualization", "1", {
    packages: ["corechart"]
});
google.setOnLoadCallback(drawChart6);

/** Method called on page loading */
$(function onLoad() {
    document.getElementById("title_chart1").style.display = "none";
    document.getElementById("title_chart3").style.display = "none";
    document.getElementById("title_chart4").style.display = "none";
    document.getElementById("chart4").style.display = "none";
    document.getElementById("title_chart5").style.display = "none";
    document.getElementById("chart5").style.display = "none";
    document.getElementById("title_chart6").style.display = "none";
    document.getElementById("chart6").style.display = "none";
    getAllReferences();
    $('#date_start').datepicker();
    $('#date_end').datepicker();
});

/** Refresh all reports */
function refreshReport() {
    var sum_parts = 0;
    document.getElementById("title_chart1").style.display = "block";
    document.getElementById("title_chart3").style.display = "block";
    document.getElementById("title_chart4").style.display = "block";
    document.getElementById("chart4").style.display = "block";
    document.getElementById("title_chart5").style.display = "block";
    document.getElementById("chart5").style.display = "block";
    document.getElementById("title_chart6").style.display = "block";
    document.getElementById("chart6").style.display = "block";
    var reference = document.getElementById("reference").value;
    var date_start = document.getElementById("date_start").value.split("/").reverse().join("-");
    var date_end = document.getElementById("date_end").value.split("/").reverse().join("-");
    var filter = document.getElementById("filter").value;
    getCompany(function(company) {
        // Chart for part consumption (maintenance)
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/" +
                "reference/" + reference +
                "/start/" + date_start +
                "/end/" + date_end +
                "/filter/" + filter,
            success: function(data) {
                var response = JSON.parse(data);
                data_charts1 = new Array(response.length + 1);
                data_charts1[0] = new Array("Part", "Used", {
                    role: "style"
                });
                for (var i = 1; i <= response.length; i++) {
                    sum_parts = sum_parts + parseInt(response[i - 1].somme);
                    var col_name;
                    if (filter == "DAY") {
                        col_name = reformatDate(response[i - 1].f);
                    } else if (filter == "MONTH") {
                        col_name = response[i - 1].f + "/" + response[i - 1].y;
                    } else if (filter == "YEAR") {
                        col_name = response[i - 1].y;
                    }

                    data_charts1[i] = new Array(col_name,
                        parseInt(response[i - 1].somme),
                        "#FFB74D");
                }
                drawChart();
                document.getElementById("sum_parts").innerHTML = sum_parts;
                document.getElementById("text_usedparts").innerHTML = "parts used for maintenance between " +
                    reformatDate(date_start) +
                    " and " +
                    reformatDate(date_end);
            }
        });
        // Chart for part consumption (transfert)
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/" +
                "reference/transfert/" + reference +
                "/start/" + date_start +
                "/end/" + date_end +
                "/filter/" + filter,
            success: function(data) {
                var response = JSON.parse(data);
                data_charts3 = new Array(response.length + 1);
                data_charts3[0] = new Array("Part", "Transfert", {
                    role: "style"
                });
                for (var i = 1; i <= response.length; i++) {
                    sum_parts = sum_parts + parseInt(response[i - 1].somme);
                    var col_name;
                    if (filter == "DAY") {
                        col_name = reformatDate(response[i - 1].f);
                    } else if (filter == "MONTH") {
                        col_name = response[i - 1].f + "/" + response[i - 1].y;
                    } else if (filter == "YEAR") {
                        col_name = response[i - 1].y;
                    }

                    data_charts3[i] = new Array(col_name,
                        parseInt(response[i - 1].somme),
                        "#BADC88");
                }
                drawChart3();
            }
        });
        // Stock quantity & Market value
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/reference/" + reference + "/stockvalue",
            success: function(data) {
                var response = JSON.parse(data);
                document.getElementById("chart4").innerHTML = response[0].stockquantity;
                document.getElementById("chart5").innerHTML = response[0].marketvalue + " " + response[0].symbol;
            }
        });
        // Draw chart by sites
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/reference/" + reference + "/localisation",
            success: function(data) {
                var response = JSON.parse(data);
                data_charts6 = new Array(response.length + 1);
                data_charts6[0] = new Array("Site", "Quantity");
                for (var i = 1; i <= response.length; i++) {
                    data_charts6[i] = new Array(response[i - 1].name,
                        parseInt(response[i - 1].partssum)
                    );
                }
                drawChart6();
            }
        });
    });
}

/** Draws chart by site */
function drawChart6() {
    var data;
    if (typeof(data_charts6) != "undefined") {
        data = google.visualization.arrayToDataTable(data_charts6);
    } else {
        data = google.visualization.arrayToDataTable([
            ['Site', 'Quantity'],
            ['SiteA', 0],
            ['SiteB', 0]
        ]);
    }

    var options = {
        backgroundColor: {
            fill: 'transparent'
        },
        pieHole: 0.4,
        titleTextStyle: {
            color: '#FFF'
        },
        legendTextStyle: {
            color: '#FFF'
        },
        /*colors: ['#009933', "#990000"]*/
    };

    var chart = new google.visualization.PieChart(document.getElementById('partslocalisation_values'));
    chart.draw(data, options);

}

/** Draws chart for data_charts3 values */
function drawChart3() {
    if (typeof(data_charts3) != "undefined") {
        var data = google.visualization.arrayToDataTable(data_charts3);
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
                position: "none"
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
            backgroundColor: {
                fill: 'transparent'
            },
            titleTextStyle: {
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
                position: "none"
            },
            animation: {
                duration: 1000,
                easing: 'in'
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("consumptiontransfert_values"));
        chart.draw(data, optionsData); // 1st draw with data (animate)
        chart.draw(view, optionsView); // 2nd draw with data & view
    }
}

/** Draws chart for data_charts1 values */
function drawChart() {
    if (typeof(data_charts1) != "undefined") {
        var data = google.visualization.arrayToDataTable(data_charts1);
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
                position: "none"
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
            backgroundColor: {
                fill: 'transparent'
            },
            titleTextStyle: {
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
                position: "none"
            },
            animation: {
                duration: 1000,
                easing: 'in'
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
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

/** Retrieves all references in table parts */
function getAllReferences() {
    getCompany(function(company) {
        $.ajax({
            method: "GET",
            url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/parts/all",
            success: function(data) {
                var response = JSON.parse(data);
                var content = '';
                for (var i = 0; i < response.length; i++) {
                    content = content + '<option value="' + response[i].reference + '">' + response[i].reference + '</option>';
                }
                document.getElementById("reference").innerHTML = content;
            }
        });
    });
}

/** Good date format JJ/MM/AAAA */
function reformatDate(dateStr) {
    dArr = dateStr.split("-");
    return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
}