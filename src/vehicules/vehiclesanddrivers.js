/**
 * vehiclesanddrivers.js
 *
 * @see vehiclesanddrivers.php
 * @author Joey Bronner
 * @version 1.0
 */

/** Method called on page loading */
$(function onLoad() {
  document.getElementById("vehiclesanddriversdetail").style.display = "none";
  document.getElementById("addentry").style.display = "none";
  getAllVehicles();
  getAllDrivers();
  $('#date_start').datepicker();
  $('#date_end').datepicker();
  $('#acquisition_drivinglicence').datepicker();
  $('#expire_drivinglicence').datepicker();
});

/** Retrieves all drivers */
function getAllDrivers() {
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/vehicles/drivers",
      success: function(data) {
        var response = JSON.parse(data);
        var content = '<option selected disabled>Liste des conducteurs</option>';
        for (var i = 0; i < response.length; i++) {
          content = content + '<option value="' + response[i].id_driver + '">' + response[i].firstname + ' ' + response[i].lastname + '(' + response[i].nr_drivinglicence + ')</option>';
        }
        document.getElementById("listdrivers").innerHTML = content;
      }
    });
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
        for (var i = 0; i < response.length; i++) {
          content = content + '<option value="' + response[i].id_vehicle + '">' + response[i].nr_plate + '</option>';
        }
        document.getElementById("listvehicles").innerHTML = content;
      }
    });
  });
};

/** Retrieves company's ID */
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

/** Displays a vehicle by ID */
function displayVehicle(id) {
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/vehicles/" + id + "/drivers",
      success: function(data) {
        var response = JSON.parse(data);
        var dataSet = new Array(response.length);
        for (var i = 0; i < response.length; i++) {
          dataSet[i] = new Array(response[i].firstname + " " + response[i].lastname,
            response[i].nr_drivinglicence,
			reformatDate(response[i].acquisition_drivinglicence),
            reformatDate(response[i].expire_drivinglicence),
            reformatDate(response[i].date_start),
            reformatDate(response[i].date_end),
            '<a href="javascript:removeEntry(' + response[i].id_driveduration + ');"><i id="icon_remove" class="fa fa-times"></i></a>');
        }

        $('#drivers').html('<table class="display" id="example"></table>');

        $('#example').dataTable({
          "data": dataSet,
          "bPaginate": true,
          "bLengthChange": true,
          "bStateSave": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": true,
          "columns": [{
            "title": "Conducteur",
            "class": "center fctbw"
          }, {
            "title": "N° de permis de conduire",
            "class": "center fctbw"
          }, {
            "title": "Obtention",
            "class": "center fctbw"
          }, {
            "title": "Expiration",
            "class": "center fctbw"
          }, {
            "title": "Début conduite",
            "class": "center fctbw"
          }, {
            "title": "Fin conduite",
            "class": "center fctbw"
          }, {
            "title": "",
            "class": "center fctbw"
          }]
        });
      }
    });

    document.getElementById("vehiclesanddriversdetail").style.display = "block";

  });
}

/** Shows new drivers fields */
function showAddDriverFields() {
  document.getElementById("addentry").style.display = "block";
  document.getElementById("btshowfields").style.display = "none";
}

/** Removes a drive moment */
function removeEntry(id_driveduration) {
  getCompany(function(company) {
    console.log("http://think-parc.com/webservice/v1/companies/" + company + "/administratives/driveduration/" + id_driveduration);
    $.ajax({
      method: "DELETE",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/driveduration/" + id_driveduration,
      success: function(data) {
        $(document).ready(function() {
          json = JSON.parse(data);
          displayVehicle(document.getElementById("listvehicles").value);
        });
      }
    });
  });
}

/** Inserts drive duration or drive duration and new driver */
function addEntry() {
  if (document.getElementById("listdrivers").disabled) {
    insertDriver(function(id_driver) {
      insertDriveDuration(id_driver);
    });
  } else {
    insertDriveDuration(document.getElementById("listdrivers").value);
  }

}

/** Inserts a new drive duration */
function insertDriveDuration(id_driver) {
  var id_vehicle = document.getElementById("listvehicles").value;
  var date_start = document.getElementById("date_start").value.split("/").reverse().join("-");
  var date_end = document.getElementById("date_end").value.split("/").reverse().join("-");
  getCompany(function(company) {
    $.ajax({
      method: "POST",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/vehicles/" + id_vehicle + "/driver/existant/" + id_driver + "/" + date_start + "/" + date_end,
      success: function(data) {
        json = JSON.parse(data);
        document.getElementById("firstname").value = '';
        document.getElementById("lastname").value = '';
        document.getElementById("nr_drivinglicence").value = '';
        document.getElementById("acquisition_drivinglicence").value = '';
        document.getElementById("expire_drivinglicence").value = '';
        document.getElementById("date_start").value = '';
        document.getElementById("date_end").value = '';
        displayVehicle(document.getElementById("listvehicles").value);
      }
    });
  });
}

/** Inserts a new driver */
function insertDriver(handleData) {
  var firstname = document.getElementById("firstname").value;
  var lastname = document.getElementById("lastname").value;
  var nr_drivinglicence = document.getElementById("nr_drivinglicence").value;
  var acquisition_drivinglicence = document.getElementById("acquisition_drivinglicence").value.split("/").reverse().join("-");
  var expire_drivinglicence = document.getElementById("expire_drivinglicence").value.split("/").reverse().join("-");
  getCompany(function(company) {
    $.ajax({
      method: "POST",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/vehicles/drivers/" + firstname + "/" + lastname + "/" + nr_drivinglicence + "/" + acquisition_drivinglicence + "/" + expire_drivinglicence,
      success: function(data) {
        json = JSON.parse(data);
        handleData(json["Success"]);
      }
    });
  });
}

/** Shows new driver fields */
function newDriverFields() {
  var list = false;
  var newdriver = true;
  getAllDrivers();
  if (document.getElementById("listdrivers").disabled) {
    document.getElementById("driver_choice").className = "fa fa-sort-down";
    list = false;
    newdriver = true;
  } else {
    document.getElementById("driver_choice").className = "fa fa-sort-up";
    document.getElementById("listdrivers").value = 0;
    list = true;
    newdriver = false;
  }
  document.getElementById("listdrivers").disabled = list; 
  document.getElementById('firstname').disabled = newdriver;
  document.getElementById('lastname').disabled = newdriver;
  document.getElementById('nr_drivinglicence').disabled = newdriver;
  document.getElementById('acquisition_drivinglicence').disabled = newdriver;
  document.getElementById('expire_drivinglicence').disabled = newdriver;
}

/** Shows drivers fields */
function showAddDriverFields() {
  document.getElementById("btshowfields").style.display = "none";
  document.getElementById("addentry").style.display = "block";
}

/** Good date format JJ/MM/AAAA */
function reformatDate(dateStr) {
  dArr = dateStr.split("-");
  return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
}