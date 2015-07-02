/**
 * addmaintenance.js
 *
 * @see addmaintenance.php
 * @author Joey Bronner
 * @version 1.0
 */
 
/** Global public variables used and re-used in some methods */
var totalitems = 0;
var buyingprice = "";
var symbol = "";
var designation = "";

/** Method called on page loading */
$(function onLoad() {
  getAllVehicles();
  getCurrencies();
  getTypeMaintenance();
  setNowIntoDateStart();
  $('#date_startmaintenance').datepicker();
  $('#date_endmaintenance').datepicker();
});

/** Sets the current date into the start field */
function setNowIntoDateStart() {
  document.getElementById('date_startmaintenance').value = reformatDate(new Date().toDateInputValue());
}

/** Date prototype JJ/MM/AAAA */
Date.prototype.toDateInputValue = (function() {
  var local = new Date(this);
  local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
  return local.toJSON().slice(0, 10);
});

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

/** Retrieves all vehicles data */
function getAllVehicles() {
	console.log("retrieve all vehicles");
  getCompany(function(company) {
	console.log("http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/freevehicles");
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/freevehicles",
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

/** Retrieves all type of maintenances */
function getTypeMaintenance() {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/maintenance/typemaintenance",
    success: function(data) {
      var response = JSON.parse(data);
      var content = '<option selected disabled>Type</option>';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_typemaintenance + '">' + response[i].typemaintenance + '</option>';
      }
      document.getElementById("typemaintenance").innerHTML = content;
    }
  });
};

/** Allows to add a new part for this maintenance */
function addParts() {
  var radios = document.getElementsByName('stockselected');
  for (var i = 0; i < radios.length; i++) {
    if (radios[i].checked) {
      var reference = document.getElementById("reference").value;
      var quantity = document.getElementById("quantity").value;
      var stocktopickin = radios[i].value;
      addPartToTable(reference, quantity, stocktopickin);
      /* Close popup */
      cancelAddPart();
    }
  }
}

/** Allows to add a new part to the table */
function addPartToTable(reference, quantity, stocktopickin) {
  totalitems++;
  var newpart = '<tr id="part-' + totalitems + '">' +
    '<td width="20%" id="ref-' + totalitems + '">' + reference + '</td>' +
    '<td width="30%" id="des-' + totalitems + '">' + designation + '</td>' +
    '<td width="10%" id="qty-' + totalitems + '">' + quantity + '</td>' +
    '<td width="15%" id="stk-' + totalitems + '">' + stocktopickin + '</td>' +
    '<td width="15%" id="prx-' + totalitems + '">' + buyingprice + ' ' + symbol + '</td>' +
    '<td width="10%"><a href="javascript:removePartFromTable(' + totalitems + ')"><i class="fa fa-times"></i></a></td>' +
    '</tr>';
  document.getElementById("partstable").innerHTML = document.getElementById("partstable").innerHTML + newpart;
}

/** Removes a specific part from the table */
function removePartFromTable(id) {
  document.getElementById("part-" + id).remove();
}

/** Remove child prototype  */
Element.prototype.remove = function() {
  this.parentElement.removeChild(this);
}

/** Retrieves all type of maintenances */
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
  for (var i = 0, len = this.length; i < len; i++) {
    if (this[i] && this[i].parentElement) {
      this[i].parentElement.removeChild(this[i]);
    }
  }
}

/** Retrieves available parts */
function showPartsStock() {
  var reference = document.getElementById("reference").value;
  var quantity = document.getElementById("quantity").value;
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/stock/" + reference + "/quantity/" + quantity,
      success: function(data) {
        var response = JSON.parse(data);
        var content = '<center><table>' +
          '<tbody style="display:block; height:250px; overflow-y:auto;">' +
          '<tr>' +
          '<td></td>' +
          '<td class="littletable"><h6>Site</h6></td>' +
          '<td class="littletable"><h6>Qty</h6></td>' +
          '<td class="littletable"><h6>Driveway</h6></td>' +
          '<td class="littletable"><h6>Bay</h6></td>' +
          '<td class="littletable"><h6>Position</h6></td>' +
          '<td class="littletable"><h6>Rack</h6></td>' +
          '<td class="littletable"><h6>Locker</h6></td>' +
          '</tr>';
        for (var i = 0; i < response.length; i++) {
          content = content + '<tr>' +
            '<td class="littletable"><input type="radio" name="stockselected" value="' + response[i].id_stock + '" />' + '</td>' +
            '<td class="littletable"><h6>' + response[i].name + '</h6></td>' +
            '<td class="littletable"><h6>' + response[i].quanty + '</h6></td>' +
            '<td class="littletable"><h6>' + response[i].driveway + '</h6></td>' +
            '<td class="littletable"><h6>' + response[i].bay + '</h6></td>' +
            '<td class="littletable"><h6>' + response[i].position + '</h6></td>' +
            '<td class="littletable"><h6>' + response[i].rack + '</h6></td>' +
            '<td class="littletable"><h6>' + response[i].locker + '</h6></td>' +
            '</tr>';
          buyingprice = response[i].buyingprice;
          designation = response[i].designation;
          symbol = response[i].symbol;
        }
        document.getElementById("stockcontent").innerHTML = content;
      }
    });
  });
}

/** Cancels the adding part popup & resets values */
function cancelAddPart() {
  /* Reset values */
  document.getElementById("stockcontent").innerHTML = "";
  document.getElementById("reference").value = "";
  document.getElementById("quantity").value = "";

  /* Close popup */
  popup('custompopup');
}

/** On value change */
function valuesChanges() {
  var reference = document.getElementById("reference").value;
  var quantity = document.getElementById("quantity").value;
  if (reference != "" && isNaN(quantity) == false && quantity > 0) {
    showPartsStock();
  } else {
    document.getElementById("stockcontent").innerHTML = "<h6>Not available is your stock.</h6>";
  }
}

/** Adds a new maintenance for the selected vehicle */
function addNewMaintenance() {
  if (document.getElementById("listvehicles").selectedIndex == 0) {
    $.toast({
      heading: "Error",
      text: "Please select a vehicle",
      icon: "error"
    });
    return false;
  }
  if (document.getElementById("typemaintenance").selectedIndex == 0) {
    $.toast({
      heading: "Error",
      text: "Please select a type of maintenance",
      icon: "error"
    });
    return false;
  }
  /* Ok! Now we can retrieve values */
  var id_vehicle = document.getElementById("listvehicles").value;
  var date_startmaintenance = document.getElementById("date_startmaintenance").value.split("/").reverse().join("-");
  var date_endmaintenance = document.getElementById("date_endmaintenance").value.split("/").reverse().join("-");
  var id_typemaintenance = document.getElementById("typemaintenance").value;
  var labour_hours = document.getElementById("labour_hours").value;
  var labour_hourlyrate = document.getElementById("labour_hourlyrate").value;
  var id_currency = document.getElementById("currencies").value;
  var commentary = document.getElementById("commentary").value;

  // Tranform potential NULL values (commentary & date of end of maintenance)
  date_endmaintenance = ((date_endmaintenance == "") ? "NULL" : date_endmaintenance);
  commentary = ((commentary == "") ? "NULL" : commentary);

  // Call [POST] to add new maintenance in database
  getCompany(function(company) {
    $.ajax({
      url: 'http://www.think-parc.com/webservice/v1/companies/' + company +
        '/maintenance' +
        '/vehicle/' + id_vehicle +
        '/start/' + date_startmaintenance +
        '/end/' + date_endmaintenance +
        '/type/' + id_typemaintenance +
        '/hours/' + labour_hours +
        '/rate/' + labour_hourlyrate +
        '/curr/' + id_currency +
        '/commentary/' + commentary,
      type: 'POST',
      success: function(data) {
        var response = JSON.parse(data);
        var id_maintenance = response.id;

        for (var i = 1; i <= totalitems; i++) {
          var id_stock = document.getElementById("stk-" + i).innerHTML;
          var quantity = document.getElementById("qty-" + i).innerHTML;
          // Update stock available stock 
          $.ajax({
            url: 'http://www.think-parc.com/webservice/v1/companies/' + company +
              '/stock/' + id_stock +
              '/quantity/' + quantity,
            type: 'PUT',
            async: false,
            success: function(data) {
              // Add all used parts for this maintenance 
              $.ajax({
                url: 'http://www.think-parc.com/webservice/v1/companies/' + company +
                  '/maintenance/' + id_maintenance +
                  '/stock/' + id_stock +
                  '/quantity/' + quantity,
                type: 'POST'
              });
            }
          });
        }
        // Reset values 
        getAllVehicles();
        getCurrencies();
        getTypeMaintenance();
        document.getElementById('date_startmaintenance').value = reformatDate(new Date().toDateInputValue());
        document.getElementById("date_endmaintenance").value = '00/00/0000';
        document.getElementById("labour_hours").value = 0;
        document.getElementById("labour_hourlyrate").value = 0;
        document.getElementById("commentary").value = "";
        // Clear parts table
        for (var i = 1; i <= totalitems; i++) {
          try {
            document.getElementById("part-" + i).remove();
          } catch (e) { /* nothing */ }
        }
        totalitems = 0;

        // Display confirmation toast
        $.toast({
          heading: "Success",
          text: "Vehicle successfuly added in maintenance.",
          icon: "success"
        });

      }
    });
  });
}

/** Reformats Date from YYYY-MM-DD to JJ/MM/AAAA */
function reformatDate(dateStr) {
	dArr = dateStr.split("-");
	return dArr[2]+ "/" +dArr[1]+ "/" +dArr[0];
}