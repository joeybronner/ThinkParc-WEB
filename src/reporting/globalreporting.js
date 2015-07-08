/**
 * globalreporting.js
 *
 * @see globalreporting.php
 * @author Said KHALID
 * @version 1.0
 */
/** Global public variables  */
// Load charts
var data_charts2;
var data_charts3;
var data_charts4;
var vehicles_available = 0;
var total = 0;
var enstock = 0;

google.load("visualization", "1", {
  packages: ["corechart"]
});
google.setOnLoadCallback(drawChart3);
var id_company = document.getElementById('fct_id_company').innerHTML;

/** Method who called on page loading  **/

$(function onLoad() {
  var id_company = document.getElementById('fct_id_company').innerHTML;
  document.getElementById("chart1").style.visibility = "hidden";
  document.getElementById("title_values").style.visibility = "hidden";
  document.getElementById("title_valuesofstock").style.visibility = "hidden";
  getSites(id_company);

});

/** Refresh all reporting  **/
function refreshReport() {
  var sum_parts = 0;
  document.getElementById("chart1").style.visibility = "visible";
  document.getElementById("title_values").style.visibility = "visible";
  document.getElementById("title_valuesofstock").style.visibility = "visible";

  var id_site = document.getElementById("listproducts").value;

  /** Begin Ajax functions for providing data to chart  **/

  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/reporting/getTotalVehicles/id_site/" + id_site,
    success: function(data) {
      var response = JSON.parse(data);
      data_charts2 = new Array(3);
      data_charts2[0] = new Array('Site', 'Count');
      data_charts2[1] = new Array('Other sites', parseInt(response[0].total) - parseInt(response[0].bysite));
      data_charts2[2] = new Array(getSelectedText('listproducts'), parseInt(response[0].bysite));

      drawChart2();

    },
    async: false
  });

  /** End of first chart data  **/

  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/reporting/getState/id_site/" + id_site,
    success: function(data) {
      var response = JSON.parse(data);
      data_charts3 = new Array(response.length + 1);
      data_charts3[0] = new Array("State", "Total");
      for (var i = 1; i <= response.length; i++) {
        data_charts3[i] = new Array(response[i - 1].state,
          parseInt(response[i - 1].total)
        );
      }
      drawChart3();
    },
    async: false
  });

  /** End of second chart data  **/

  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/reporting/getTotalValuesVehicles/id_site/" + id_site,
    success: function(data) {
      var response = JSON.parse(data);
      document.getElementById("chart4").innerHTML = numberWithCommas(response[0].total) + " " + response[0].symbol;
    }


  });

  /** End of third chart data  **/

  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/reporting/getTotalValuesOfStock/id_site/" + id_site,
    success: function(data) {
      var response = JSON.parse(data);
      document.getElementById("chart5").innerHTML = numberWithCommas(response[0].total) + " " + response[0].symbol;
    }


  });

  /** End of fourth chart data  **/

  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/reporting/getTotalParts/id_site/" + id_site,
    success: function(data) {
      var response = JSON.parse(data);
      data_charts6 = new Array(response.length + 1);
      data_charts6[0] = new Array("Part", "Total");
      for (var i = 1; i <= response.length; i++) {
        data_charts6[i] = new Array(response[i - 1].part,
          parseInt(response[i - 1].total)
        );
      }

      drawChart6();

    },
    async: false
  });

  /** End of Ajax functions  **/
}


/** Methods of the first chart creating  **/

function drawChart2() {
  var data;
  if (typeof(vehicles_available) != "undefined") {
    data = google.visualization.arrayToDataTable(data_charts2);
  } else {
    data = google.visualization.arrayToDataTable([
      ['No values', 1]
    ]);
  }

  var options = {
    sliceVisibilityThreshold: 0,
    title: "Nombre de véhicule",
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

  var chart = new google.visualization.PieChart(document.getElementById('vehiclesum'));
  chart.draw(data, options);

}

/** Methods of the second chart creating  **/
function drawChart3() {
  var data;
  if (typeof(data_charts3) != "undefined") {
    data = google.visualization.arrayToDataTable(data_charts3);
  } else {
    data = google.visualization.arrayToDataTable([
      ['No values', 1]
    ]);
  }

  var options = {
    sliceVisibilityThreshold: 0,
    title: "Parc/Hors-parc",
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
    colors: ['#009933', "#990000"]
  };

  var chart = new google.visualization.PieChart(document.getElementById('vehicleenstock'));
  chart.draw(data, options);

}

/** Methods of the third chart creating  **/
function drawChart4() {
  var data;
  if (typeof(vehicles_available) != "undefined") {
    data = google.visualization.arrayToDataTable(data_charts4);
  } else {
    data = google.visualization.arrayToDataTable([
      ['No values', 1]
    ]);
  }

  var options = {
    sliceVisibilityThreshold: 0,
    title: "Etat du véhicule",
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

  var chart = new google.visualization.PieChart(document.getElementById('vehiclevalues'));
  chart.draw(data, options);

}

/** Methods of the fourth chart creating  **/
function drawChart6() {
  var data;
  if (typeof(enstock) != "undefined" && data_charts6.length > 1) {
    data = google.visualization.arrayToDataTable(data_charts6);
  } else {
    data = google.visualization.arrayToDataTable([
      ['No values', 1]
    ]);
  }

  var options = {
    sliceVisibilityThreshold: 0,
    title: "Nombre de référence en stock",
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
    slices: true
  };

  var chart = new google.visualization.PieChart(document.getElementById('stockpart'));
  chart.draw(data, options);

}

function getSelectedText(elementId) {
  var elt = document.getElementById(elementId);
  if (elt.selectedIndex == -1)
    return null;
  return elt.options[elt.selectedIndex].text;
}

/** Returns a number with commas */
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/** Method who retrieves all sites */
function getSites(id_company) {

  var id_company = document.getElementById('fct_id_company').innerHTML;

  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/" + id_company + "/sites",
    success: function(data) {

      var response = JSON.parse(data);
      var content = '<option selected disabled>Liste</option>';

      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_site + '">' + response[i].name + '</option>';
      }

      document.getElementById("listproducts").innerHTML = content;
    }
  });
};

/** End of file **/