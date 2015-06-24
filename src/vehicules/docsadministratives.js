/**
 * docsadministratives.js
 *
 * @see docsadministratives.php
 * @author Joey Bronner
 * @version 1.0
 */

 /** Method called on page loading */
 $(function onLoad() {
  document.getElementById("administrativeblock").style.display = "none";
  getAllVehicles();
  getInsurances();
  $('#date_lastcontrol').datepicker();
  $('#date_nextcontrol').datepicker();
  $('#date_startinsurance').datepicker();
  $('#date_endinsurance').datepicker();
});

/** Get all insurances companies */
function getInsurances() {
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/insurances/all",
      success: function(data) {
        var response = JSON.parse(data);
        var content = '<option selected disabled>Veuillez sélectionner un assureur dans la liste</option>';
        var contenttable = '';
        for (var i = 0; i < response.length; i++) {
          content = content + '<option value="' + response[i].id_insurance + '">' + response[i].name +
            ' (' + response[i].address_ligne1 + ', ' + response[i].zipcode + ' ' + response[i].country +
            ')</option>';
        }
        document.getElementById("insurances").innerHTML = content;
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

/** Displays a specific vehicle by ID */
function displayVehicle(id) {
  document.getElementById("administrativeblock").style.display = "block";
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/" + id,
      success: function(data) {
        var response = JSON.parse(data);
        for (var i = 0; i < response.length; i++) {
          document.getElementById("nr_contract").value = response[i].nr_contract;
          document.getElementById("date_lastcontrol").value = reformatDate(response[i].date_lastcontrol);
          document.getElementById("date_nextcontrol").value = reformatDate(response[i].date_nextcontrol);
          document.getElementById("date_startinsurance").value = reformatDate(response[i].date_startinsurance);
          document.getElementById("date_endinsurance").value = reformatDate(response[i].date_endinsurance);
          document.getElementById("insurances").value = response[i].id_insurance;
        }

        if (response.length < 1) {
          document.getElementById("nr_contract").value = '';
          document.getElementById("date_lastcontrol").value = '';
          document.getElementById("date_nextcontrol").value = '';
          document.getElementById("date_startinsurance").value = '';
          document.getElementById("date_endinsurance").value = '';
          document.getElementById("insurances").value = 0;
          document.getElementById("addAdministrative").style.display = "block";
          document.getElementById("updateAdministrative").style.display = "none";
        } else {
          document.getElementById("addAdministrative").style.display = "none";
          document.getElementById("updateAdministrative").style.display = "block";

        }
      }
    });
  });
}

/** Hides the vehicle block */
function hideVehicles() {
  document.getElementById("administrativeblock").style.display = "none";
}

/** Shows new insurance fields */
function newinsurancefields() {
  var list = true;
  var newinsurance = false;
  if (document.getElementById("insurances").disabled) {
    restartNewInsuranceValues();
    getInsurances();
    list = false;
    newinsurance = true;
  } else {
    document.getElementById("insur_choice").className = "fa fa-sort-down";
    document.getElementById("insurances").value = 0;
    list = true;
    newinsurance = false;
  }
  document.getElementById("insurances").disabled = list;
  document.getElementById('ins_name').disabled = newinsurance;
  document.getElementById('ins_add1').disabled = newinsurance;
  document.getElementById('ins_add2').disabled = newinsurance;
  document.getElementById('ins_add3').disabled = newinsurance;
  document.getElementById('ins_zipcode').disabled = newinsurance;
  document.getElementById('ins_phone').disabled = newinsurance;
  document.getElementById('ins_email').disabled = newinsurance;
  document.getElementById('ins_city').disabled = newinsurance;
  document.getElementById('ins_country').disabled = newinsurance;
}

/** Resets insurance fields (after insertion for example) */
function restartNewInsuranceValues() {
  document.getElementById("insur_choice").className = "fa fa-sort-up";
  document.getElementById('ins_name').value = "";
  document.getElementById('ins_add1').value = "";
  document.getElementById('ins_add2').value = "";
  document.getElementById('ins_add3').value = "";
  document.getElementById('ins_zipcode').value = "";
  document.getElementById('ins_phone').value = "";
  document.getElementById('ins_email').value = "";
  document.getElementById('ins_city').value = "";
  document.getElementById('ins_country').value = "";
}

/** Update insurances values */
function saveChangesAdministrative() {
  var id_vehicle = document.getElementById("listvehicles").value;
  if (document.getElementById('ins_name').value == '') {
    updateDocsAdministrative(document.getElementById("insurances").value, id_vehicle);
  } else {
    insertInsurance(function(insurance) {
      updateDocsAdministrative(insurance, id_vehicle);
      newinsurancefields();
    });
  }
  hideVehicles();
  getAllVehicles();
}

function saveAdministrative() {
  // First add new insurance if necessary
  var id_vehicle = document.getElementById("listvehicles").value;
  if (document.getElementById('ins_name').value == '') {
    // Insert administrative doc
    insertDocsAdministrative(document.getElementById("insurances").value, id_vehicle);
  } else {
    // Insert insurance
    insertInsurance(function(insurance) {
      // Insert administrative doc
      insertDocsAdministrative(insurance, id_vehicle);
    });
  }
  newinsurancefields();
  hideVehicles();
  getAllVehicles();
}

/** Adds new insurances values for a specific vehicle */
function updateDocsAdministrative(id_insurance, id_vehicle) {
  getCompany(function(company) {
    var nr_contract = document.getElementById("nr_contract").value;
    var date_lastcontrol = document.getElementById("date_lastcontrol").value.split("/").reverse().join("-");
    var date_nextcontrol = document.getElementById("date_nextcontrol").value.split("/").reverse().join("-");
    var date_startinsurance = document.getElementById("date_startinsurance").value.split("/").reverse().join("-");
    var date_endinsurance = document.getElementById("date_endinsurance").value.split("/").reverse().join("-");
    $.ajax({
      method: "PUT",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/docs/" + id_vehicle + "/" + nr_contract + "/" + date_lastcontrol + "/" + date_nextcontrol + "/" + date_startinsurance + "/" + date_endinsurance + "/" + id_insurance,
      success: function(data) {
        $(document).ready(function() {
          document.getElementById("addAdministrative").style.display = "none";
          document.getElementById("updateAdministrative").style.display = "block";
          $.toast({
            heading: "Success",
            text: "Administrative document successfully updated.",
            icon: "success"
          });
        });
      },
      error: function(xhr, status, error) {
        $(document).ready(function() {
          $.toast({
            heading: "Error",
            text: "An error occured",
            icon: "error"
          });
        });
      }
    });
  });
}

/** Adds a new insurance company */
function insertInsurance(handleData) {
  var ins_name = document.getElementById("ins_name").value;
  var ins_phone = document.getElementById("ins_phone").value;
  var ins_email = document.getElementById("ins_email").value;
  var ins_add1 = document.getElementById("ins_add1").value;
  var ins_add2 = document.getElementById("ins_add2").value;
  var ins_add3 = document.getElementById("ins_add3").value;
  var ins_zipcode = document.getElementById("ins_zipcode").value;
  var ins_city = document.getElementById("ins_city").value;
  var ins_country = document.getElementById("ins_country").value;
  getCompany(function(company) {
    $.ajax({
      method: "POST",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/insurances/" + ins_name + "/" + ins_phone + "/" + ins_email + "/" + ins_add1 + "/" + ins_add2 + "/" + ins_add3 + "/" + ins_zipcode + "/" + ins_city + "/" + ins_country,
      success: function(data) {
        json = JSON.parse(data);
        handleData(json["Success"]);
      }
    });
  });
}

/** Adds new administratives docs */
function insertDocsAdministrative(id_insurance, id_vehicle) {
  // Add into docsadministrative
  getCompany(function(company) {
    var nr_contract = document.getElementById("nr_contract").value;
    var date_lastcontrol = document.getElementById("date_lastcontrol").value.split("/").reverse().join("-");
    var date_nextcontrol = document.getElementById("date_nextcontrol").value.split("/").reverse().join("-");
    var date_startinsurance = document.getElementById("date_startinsurance").value.split("/").reverse().join("-");
    var date_endinsurance = document.getElementById("date_endinsurance").value.split("/").reverse().join("-");
    $.ajax({
      method: "POST",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/administratives/docs/" + id_vehicle + "/" + nr_contract + "/" + date_lastcontrol + "/" + date_nextcontrol + "/" + date_startinsurance + "/" + date_endinsurance + "/" + id_insurance,
      success: function(data) {
        $(document).ready(function() {
          document.getElementById("addAdministrative").style.display = "none";
          document.getElementById("updateAdministrative").style.display = "block";
          $.toast({
            heading: "Success",
            text: "Administrative document successfully added.",
            icon: "success"
          });
        });
      },
      error: function(xhr, status, error) {
        $(document).ready(function() {
          $.toast({
            heading: "Error",
            text: "An error occured",
            icon: "error"
          });
        });
      }
    });
  });
}

/** Good date format for displaying JJ/MM/AAAA */
function reformatDate(dateStr) {
  dArr = dateStr.split("-");
  return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
}