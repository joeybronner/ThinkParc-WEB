/**
 * historymaintenance.js
 *
 * @see historymaintenance.php
 * @author Joey Bronner
 * @version 1.0
 */

/** Global public variables used and re-used in some methods */
var totalitems = 0;
var days_maintenance = 0;
var days_available = 0;
var id_maintenance = "";
buyingprice = "";
symbol = "";
designation = "";
var partsToDelete = { partToDelete: [] };
var partsToAdd = { partToAdd: [] };

/** Google chart initialization */
google.load("visualization", "1", {
  packages: ["corechart"]
});

/** Method called on page loading */
$(function onLoad() {
  getAllVehicles();
});

/** Retrieves values for a specific maintenance */
function showMaintenanceHistoryForSpecificVehicle(id_vehicle) {
  for (var i = 1; i <= totalitems; i++) {
    try {
      $("[id^='maintenance-']").remove();
    } catch (e) { /* nothing */ }
  }
  totalitems = 0;
  getVehicleHistory(id_vehicle);
  getDaysInMaintenance(id_vehicle);
  document.getElementById('maintenancedetails').style.display = 'block';
}

/** Draws the chart of available and maintenance parts */
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Status', 'Days'],
    ['Available', days_available],
    ['Maintenance', days_maintenance]
  ]);

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
    colors: ['#009933', "#990000"]
  };

  var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
  chart.draw(data, options);
}

/** Gets the number of days in maintenance between date of buy and today */
function getDaysInMaintenance(id_vehicle) {
  getCompany(function(company) {
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
            // Draw chart
            days_maintenance = parseInt(maintenancedays);
            days_available = parseInt(((date_now - date_buy) / 86400000) - days_maintenance);
            drawChart();
          },
          async: false
        });
      },
      async: false
    });
  });
}

/** Date prototype JJ/MM/AAAA */
Date.prototype.yyyymmdd = function() {
  var yyyy = this.getFullYear().toString();
  var mm = (this.getMonth() + 1).toString();
  var dd = this.getDate().toString();
  return yyyy + '-' + (mm[1] ? mm : "0" + mm[0]) + '-' + (dd[1] ? dd : "0" + dd[0]);
};

/** Retrieves all currencies */
function getCurrencies() {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/stocks/currencies",
    success: function(data) {
      var response = JSON.parse(data);
      var content = '';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_currency + '">' + response[i].symbol + '</option>';
      }
      document.getElementById("currencies").innerHTML = content;
    }
  });
};

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
        var content = '<option selected disabled>Liste des véhicules</option>';
        var contenttable = '';
        for (var i = 0; i < response.length; i++) {
          content = content + '<option value="' + response[i].id_vehicle + '">' + response[i].nr_plate + '</option>';
        }
        document.getElementById("listvehicles").innerHTML = content;
      }
    });
  });
};

/** Retrieves the history for a specific vehicle */
function getVehicleHistory(id_vehicle) {
  document.getElementById('partsdetails').style.display = 'none';
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehicle/" + id_vehicle + "/allmaintenances",
      success: function(data) {
        var response = JSON.parse(data);
        for (var i = 0; i < response.length; i++) {
          addMaintenanceToTable(response[i].id_maintenance,
            reformatDate(response[i].date_startmaintenance),
            reformatDate(response[i].date_endmaintenance),
            response[i].typemaintenance,
            response[i].labour_hours,
            response[i].labour_hourlyrate,
            response[i].symbol);
        }
      }
    });
  });
}

/** Inserts a maintenance history into the table */
function addMaintenanceToTable(id_maintenance, start, end, typemaintenance, hours, rate, symbol) {
  totalitems++;
  var id_vehicle = document.getElementById('listvehicles').value;
  var newmaintenance = '<tr id="maintenance-' + id_maintenance + '">' +
    '<td width="15%">' + start + '</td>' +
    '<td width="15%">' + end + '</td>' +
    '<td width="20%">' + typemaintenance + '</td>' +
    '<td width="15%">' + hours + '</td>' +
    '<td width="15%">' + rate + ' ' + symbol + '</td>' +
    '<td width="10%" id="' + totalitems + '"><a href="javascript:removeMaintenanceFromTable(' + id_maintenance + ', ' + id_vehicle + ')"><i class="fa fa-times"></i></a></td>' +
    '<td width="10%"><a href="javascript:showPartsForMaintenance(' + id_maintenance + ')"><i class="fa fa-search"></i></a></td>' +
    '</tr>';
  document.getElementById("maintenancestable").innerHTML = document.getElementById("maintenancestable").innerHTML + newmaintenance;
}

/** Retrieves the detailed parts for a specific maintenance */
function showPartsForMaintenance(id_maintenance) {
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/parts/" + id_maintenance,
      success: function(data) {
        var response = JSON.parse(data);
        var dataSet = new Array(response.length);
        for (var i = 0; i < response.length; i++) {
          dataSet[i] = new Array(response[i].reference,
            response[i].designation,
            response[i].quantity,
            response[i].buyingprice + response[i].symbol);
        }
        document.getElementById('partsdetails').style.display = 'block';
        $('#parts').html('<table class="display" cellspacing="0" width="100%" id="example"></table>');
        $('#example').dataTable({
          "data": dataSet,
          "scrollX": true,
          "bPaginate": true,
          "bLengthChange": true,
          "bStateSave": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": true,
          "columns": [{
            "title": "Reference",
            "class": "center fctbw"
          }, {
            "title": "Description",
            "class": "center fctbw"
          }, {
            "title": "Qt",
            "class": "center fctbw"
          }, {
            "title": "Unit price",
            "class": "center fctbw"
          }]
        });
      }
    });
  });
}

/** Removes a maintenance for a specific vehicle (the linbe in the table) */
function removeMaintenanceFromTable(id_maintenance, id_vehicle) {
  document.getElementById("maintenance-" + id_maintenance).remove();
  deleteMaintenance(id_maintenance);
  document.getElementById('partsdetails').style.display = 'none';
}

/** Remove a maintenance for a specific vehicle */
function deleteMaintenance(id_maintenance) {
  getCompany(function(company) {
    $.ajax({
      url: 'http://www.think-parc.com/webservice/v1/companies/' + company + '/maintenance/' + id_maintenance,
      type: 'DELETE',
      async: false
    });
  });
}

/** Gets the size of an element */
Object.size = function(obj) {
  var size = 0,
    key;
  for (key in obj) {
    if (obj.hasOwnProperty(key)) size++;
  }
  return size;
}

/** eformates a date in french format JJ/MM/AAAA */
function reformatDate(dateStr) {
  dArr = dateStr.split("-");
  return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
}

/** Removes prototype */
Element.prototype.remove = function() {
  this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
  for (var i = 0, len = this.length; i < len; i++) {
    if (this[i] && this[i].parentElement) {
      this[i].parentElement.removeChild(this[i]);
    }
  }
}