/**
 * addvehicle.js
 *
 * @see addvehicle.php
 * @author Joey Bronner
 * @version 1.0
 */
 
 /** Method called on page loading */
 $(function() {
  $('#date_buy').datepicker();
  $('#date_entryservice').datepicker();
});

 /** Retrieves all brands */
 $(function getBrands() {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/brands",
    success: function(data) {
      var response = JSON.parse(data);
      var content = '<option selected disabled>Marque du véhicule</option>';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_brand + '">' + response[i].brand + '</option>';
      }
      document.getElementById("brand").innerHTML = content;
    }
  });
});

 /** Retrieves all models */
 function getModels(idbrand) {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/models/" + idbrand,
    success: function(data) {
      var response = JSON.parse(data);
      var content = '';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_model + '">' + response[i].model + '</option>';
      }
      document.getElementById("model").innerHTML = content;
      document.getElementById("model").disabled = false;
    }
  });
};

/** Retrieves all kinds */
$(function getKinds() {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/kinds",
    success: function(data) {
      var response = JSON.parse(data);
      var content = '<option selected disabled>Genre</option>';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_kind + '">' + response[i].kind + '</option>';
      }
      document.getElementById("kinds").innerHTML = content;
    }
  });
});

/** Retrieves all categories */
$(function getCategories() {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/categories",
    success: function(data) {
      var response = JSON.parse(data);
      var content = '<option selected disabled>Categories</option>';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_category + '">' + response[i].category + '</option>';
      }
      document.getElementById("categories").innerHTML = content;
    }
  });
});

/** Retrieves all energies (diesel, ...) */
$(function getEnergies() {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/energies",
    success: function(data) {
      var response = JSON.parse(data);
      var content = '<option selected disabled>Energies</option>';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_energy + '">' + response[i].energy + '</option>';
      }
      document.getElementById("energies").innerHTML = content;
    }
  });
});

/** Retrieves all sites */
$(function getSites() {
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/sites",
      success: function(data) {
        var response = JSON.parse(data);
        var content = '<option selected disabled>Sites</option>';
        for (var i = 0; i < response.length; i++) {
          content = content + '<option value="' + response[i].id_site + '">' + response[i].name + '</option>';
        }
        document.getElementById("sites").innerHTML = content;
      }
    });
  });
});

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

/** Retrieves vehicle's states (in parc or not) */
$(function getStates() {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/states",
    success: function(data) {
      var response = JSON.parse(data);
      var content = '<option selected disabled>Etats</option>';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_state + '">' + response[i].state + '</option>';
      }
      document.getElementById("states").innerHTML = content;
    }
  });
});

/** Retrieves all currencies */
$(function getCurrencies() {
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
});

/** Adds a new vehicle in database (check fields and insert values) */
function addVehicule() {
  var nr_plate = document.getElementById("nr_plate").value;
  var nr_serial = document.getElementById("nr_serial").value;
  var mileage = document.getElementById("mileage").value;
  var buyingprice = document.getElementById("buyingprice").value;
  var date_buy = document.getElementById("date_buy").value.split("/").reverse().join("-");
  var date_entryservice = document.getElementById("date_entryservice").value.split("/").reverse().join("-");
  var energy = document.getElementById("energies").value;
  var model = document.getElementById("model").value;
  var kind = document.getElementById("kinds").value;
  var category = document.getElementById("categories").value;
  var equipments = document.getElementById("equipments").value;
  var state = document.getElementById("states").value;
  var currency = document.getElementById("currencies").value;
  var site = document.getElementById("sites").value;
  var commentary = document.getElementById("commentary").value;

  var d_buy = new Date(date_buy);
  var d_entryservice = new Date(date_entryservice);

  if (d_entryservice <= d_buy) {
    $.ajax({
      method: "POST",
      url: "http://think-parc.com/webservice/v1/companies/sites/" + site + "/vehicles/" + nr_plate + "/" + nr_serial +
      "/" + mileage + "/" + buyingprice + "/" + date_buy + "/" + date_entryservice + "/" + energy +
      "/" + model + "/" + kind + "/" + category + "/" + equipments + "/" + state + "/" + currency +
      "/" + commentary,
      success: function(data) {
        $(document).ready(function() {
          document.getElementById("addvehicle").reset();
          $.toast({
            heading: "Success",
            text: "Vehicle successfully added.",
            icon: "success"
          });
        });
      },
      error: function(xhr, status, error) {
        $(document).ready(function() {
          $.toast({
            heading: "Error",
            text: "An error occured, a value is required for all fields. Please check your entries and try again.",
            icon: "error"
          });
        });
      }
    });
  } 
};