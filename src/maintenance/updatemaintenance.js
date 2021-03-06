/**
 * updatemaintenance.js
 *
 * @see updatemaintenance.php
 * @author Joey Bronner
 * @version 1.0
 */

/** Global public variables used and re-used in some methods */
var totalitems = 0;
var id_maintenance = "";
buyingprice = "";
symbol = "";
designation = "";
var partsToDelete = { partToDelete: [] };
var partsToAdd = { partToAdd: [] };

/** Method called on page loading */
$(function onLoad() {
  getAllVehicles();
  getCurrencies();
  getTypeMaintenance();
});

/** Retrieve detail for a specific maintenance (actually in status maintenance!) */
function showMaintenanceDetails(id_vehicle) {
  partsToDelete = {
    partToDelete: []
  };
  partsToAdd = {
    partToAdd: []
  };
  for (var i = 1; i <= totalitems; i++) {
    try {
      document.getElementById("part-" + i).remove();
    } catch (e) { /* nothing */ }
  }
  totalitems = 0;
  getVehicleMaintenanceDetail(id_vehicle);
  document.getElementById('maintenancedetails').style.display = 'block';
}

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

/** Retrieve Company's ID */
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

/** Retrieves all vehicles (currenty in status maintenance!) */
function getAllVehicles() {
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehiclesundermaintenance",
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

/** Retrieves all type of maintenance */
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

/** Retrieves the maintenance detail for a specific vehicle (used parts, dates, ...) */
function getVehicleMaintenanceDetail(id_vehicle) {
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/vehicle/" + id_vehicle,
      success: function(data) {
        var response = JSON.parse(data);
        document.getElementById('typemaintenance').value = response[0].id_typemaintenance;
        document.getElementById('date_startmaintenance').value = response[0].date_startmaintenance;
        document.getElementById('date_endmaintenance').value = response[0].date_endmaintenance;
        document.getElementById('labour_hours').value = response[0].labour_hours;
        document.getElementById('labour_hourlyrate').value = response[0].labour_hourlyrate;
        document.getElementById('currencies').value = response[0].id_currency;
        document.getElementById('commentary').value = response[0].commentary;
        id_maintenance = response[0].id_maintenance;
        $.ajax({
          method: "GET",
          url: "http://think-parc.com/webservice/v1/companies/" + company + "/maintenance/parts/" + response[0].id_maintenance,
          success: function(data) {
            var response = JSON.parse(data);
            for (var i = 0; i < response.length; i++) {
              addPartToTable(response[i].reference,
                response[i].quantity,
                response[i].id_stock,
                response[i].designation,
                response[i].buyingprice,
                response[i].symbol,
                false);
            }
          }
        });
      }
    });
  });
}

/** Allows to add a new part to the table */
function addPartToTable(reference, quantity, stocktopickin, designation, buyingprice, symbol, newpart) {
  totalitems++;
  if (newpart) {
    partsToAdd.partToAdd.push({
      "id_maintenance": id_maintenance,
      "stockid": stocktopickin,
      "quantity": quantity
    });
  }
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

/** Removes part (only in the table) */
function removePartFromTable(id) {
  partsToDelete.partToDelete.push({
    "id_maintenance": id_maintenance,
    "stockid": document.getElementById('stk-' + id).innerHTML,
    "quantity": document.getElementById('qty-' + id).innerHTML
  });
  document.getElementById("part-" + id).remove();
}

/** Update values for a specific maintenance */
function updateMaintenance() {
  /* Add new parts */
  for (var i = 0; i < Object.size(partsToAdd.partToAdd); i++) {
    var add_id_maintenance = partsToAdd.partToAdd[i].id_maintenance;
    var add_stockid = partsToAdd.partToAdd[i].stockid;
    var add_quantity = partsToAdd.partToAdd[i].quantity;
    $.ajax({
      url: 'http://www.think-parc.com/webservice/v1/companies/' + 0 +
        '/maintenance/' + add_id_maintenance +
        '/stock/' + add_stockid +
        '/quantity/' + add_quantity,
      type: 'POST',
      async: false
    });
  }
  /* Delete removed parts in database */
  for (var i = 0; i < Object.size(partsToDelete.partToDelete); i++) {
    var delete_id_maintenance = partsToDelete.partToDelete[i].id_maintenance;
    var delete_stockid = partsToDelete.partToDelete[i].stockid;
    var delete_quantity = partsToDelete.partToDelete[i].quantity;
    $.ajax({
      url: 'http://www.think-parc.com/webservice/v1/companies/' + 0 +
        '/maintenance/' + delete_id_maintenance +
        '/stock/' + delete_stockid +
        '/quantity/' + delete_quantity,
      type: 'DELETE',
      async: false
    });
  }
  /* Update global values */
  var date_endmaintenance = document.getElementById("date_endmaintenance").value;
  var labour_hours = document.getElementById("labour_hours").value;
  var labour_hourlyrate = document.getElementById("labour_hourlyrate").value;
  var id_currency = document.getElementById("currencies").value;
  var commentary = document.getElementById("commentary").value;

  /* Tranform potential NULL values (commentary & date of end of maintenance) */
  date_endmaintenance = ((date_endmaintenance == "") ? "NULL" : date_endmaintenance);
  commentary = ((commentary == "") ? "NULL" : commentary);
  $.ajax({
    url: 'http://www.think-parc.com/webservice/v1/companies/' + 0 +
      '/maintenance/' + id_maintenance +
      '/end/' + date_endmaintenance +
      '/hours/' + labour_hours +
      '/rate/' + labour_hourlyrate +
      '/curr/' + id_currency +
      '/commentary/' + commentary,
    type: 'PUT',
    async: false,
    success: function(data) {
      $.toast({
        heading: "Success",
        text: "Vehicle maintenance successfuly updated.",
        icon: "success"
      });
    }
  });
}

/** Object size prototype */
Object.size = function(obj) {
  var size = 0,
    key;
  for (key in obj) {
    if (obj.hasOwnProperty(key)) size++;
  }
  return size;
}

/** Cancels the add part popup */
function cancelAddPart() {
  document.getElementById("stockcontent").innerHTML = "";
  document.getElementById("reference").value = "";
  document.getElementById("quantity").value = "";
  popup('custompopup');
}

/** Retrieve stock status */
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

/** Method called on page loading */
function valuesChanges() {
  var reference = document.getElementById("reference").value;
  var quantity = document.getElementById("quantity").value;
  if (reference != "" && isNaN(quantity) == false && quantity > 0) {
    showPartsStock();
  } else {
    document.getElementById("stockcontent").innerHTML = "<h6>Not available is your stock.</h6>";
  }
}

/** Retrieves the part with radio button selected */
function addParts() {
  var radios = document.getElementsByName('stockselected');
  for (var i = 0; i < radios.length; i++) {
    if (radios[i].checked) {
      var reference = document.getElementById("reference").value;
      var quantity = document.getElementById("quantity").value;
      var stocktopickin = radios[i].value;
      addPartToTable(reference, quantity, stocktopickin, designation, buyingprice, symbol, true);
      // Close popup
      cancelAddPart();
    }
  }
}

/** Remove a maintenance! */
function deleteMaintenance() {
  getCompany(function(company) {
    $.ajax({
      url: 'http://www.think-parc.com/webservice/v1/companies/' + company + '/maintenance/' + id_maintenance,
      type: 'DELETE',
      async: false,
      success: function(data) {
        $.toast({
          heading: "Success",
          text: "Vehicle maintenance successfuly removed.",
          icon: "success"
        });
        document.getElementById('maintenancedetails').style.display = 'none';
        getAllVehicles();
      }
    });
  });
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