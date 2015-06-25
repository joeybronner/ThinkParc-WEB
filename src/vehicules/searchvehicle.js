/**
 * searchvehicle.js
 *
 * @see searchvehicle.php
 * @author Joey Bronner
 * @version 1.0
 */

/** Method called on page loading */
 $(function onLoad() {
  document.getElementById("vehicleblock").style.display = "none";
  getAllVehicles();
});

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
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/" + id,
    success: function(data) {
      var response = JSON.parse(data);

	  document.getElementById("nr_plate").value = response[0].nr_plate;
	  document.getElementById("nr_serial").value = response[0].nr_serial;
	  document.getElementById("mileage").value = response[0].mileage;
	  document.getElementById("buyingprice").value = response[0].buyingprice;
	  document.getElementById("commentary").value = response[0].commentary;
	  
      // Init Datepicker
      $('#date_buy').datepicker();
      $('#date_entryservice').datepicker();

      document.getElementById("vehicleblock").style.display = "block";
      setBrands(response[0].id_brand);
      setModels(response[0].id_model, response[0].id_brand);
      setEnergies(response[0].id_energy);
      setEquipments(response[0].id_equipment);
      setStates(response[0].id_state);
      setCategories(response[0].id_category);
      setKinds(response[0].id_kind);
      setSites(response[0].id_site);
      setCurrencies(response[0].id_currency);
    }
  });
  // Vehicles files
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/" + id + "/files",
      success: function(data) {
        var response = JSON.parse(data);
        var dataSet = new Array(response.length);
        for (var i = 0; i < response.length; i++) {
          dataSet[i] = new Array(reformatDate(response[i].date_upload),
            response[i].path,
            '<a href="javascript:removeFile(' + response[i].id_file + ', ' + id + ');"><i class="fa fa-times"></i></a>',
            '<a href="javascript:downloadFile(' + response[i].id_file + ');"><i class="fa fa-download"></i></a>');
        }
        $('#fileslist').dataTable({
          "data": dataSet,
          "destroy": true,
          "bPaginate": true,
          "bLengthChange": true,
          "bStateSave": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": true,
          "columns": [{
            "title": "Date",
            "class": "center fctbw"
          }, {
            "title": "File",
            "class": "center fctbw"
          }, {
            "title": "Delete",
            "class": "center fctbw"
          }, {
            "title": "Download",
            "class": "center fctbw"
          }]
        });
      }
    });
  });
}

/** Downloads a file */
function downloadFile(id_file) {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/files/" + id_file + "/path",
    success: function(data) {
      var response = JSON.parse(data);
      window.open('../../files/files_vehicles/' + response[0].path);
    }
  });
}

/** Removes a file in list */
function removeFile(id_file, id) {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/files/" + id_file + "/path",
    success: function(data) {
      var response = JSON.parse(data);
      var path = response[0].path;
      var formData = new FormData();
      formData.append('path', path);
      var xhr = new XMLHttpRequest();
      xhr.open('POST', '../../files/removefile.php?target=files_vehicles', true);
      xhr.onload = function() {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            $.ajax({
              method: "DELETE",
              url: "http://think-parc.com/webservice/v1/files/" + id_file,
              success: function(data) {
                var response = JSON.parse(data);
                displayVehicle(id);
                $.toast({
                  heading: "Success",
                  text: "File successfully removed.",
                  icon: "success"
                });
              }
            });

          } else {
            $.toast({
              heading: "Error",
              text: "",
              icon: "error"
            });
          }
        }
      };
      xhr.send(formData);
    }
  });
}

/** Uploads a new file for this vehicle */
function uploadFile() {
  var file = document.getElementById('file-select').files[0];
  var formData = new FormData();

  // Check the file type.
  if (!file.type.match('.pdf') &&
    !file.type.match('.doc') &&
    !file.type.match('.docx') &&
    !file.type.match('.png') &&
    !file.type.match('.jpg') &&
    !file.type.match('.txt') &&
    !file.type.match('.jpeg')) {
    $(document).ready(function() {
      $.toast({
        heading: "Error",
        text: "Only documents and pictures are supported (.png, .jpg, .pdf, .doc, .docx)",
        icon: "error"
      });
    });
  } else {
    // Add file to data form
    var d = new Date();
    var generatedfilename = d.getTime() + "_" + file.name;
    formData.append('myfiles', file, generatedfilename);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../files/uploadfile.php?target=files_vehicles', true);
    xhr.onload = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          $(document).ready(function() {
            $.ajax({
              method: "POST",
              url: "http://think-parc.com/webservice/v1/files/new/1/" + generatedfilename + "/" + document.getElementById("listvehicles").value,
              success: function(data) {
                $(document).ready(function() {
                  $('#file-form').each(function() {
                    this.reset();
                  });
                  displayVehicle(document.getElementById("listvehicles").value);
                  $.toast({
                    heading: "Success",
                    text: "File successfully uploaded.",
                    icon: "success"
                  });
                });
              },
              error: function(xhr, status, error) {
                $(document).ready(function() {
                  $.toast({
                    heading: "Error",
                    text: "",
                    icon: "error"
                  });
                });
              }
            });
          });
        } else {
          $(document).ready(function() {
            $.toast({
              heading: "Error",
              text: "",
              icon: "error"
            });
          });
        }
      }
    };
    xhr.send(formData);
  }
}

/** Updates currencie */
function setCurrencies(id_currency) {
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
      document.getElementById("currencies").value = id_currency;
    }
  });
};

/** Updates affected site */
function setSites(id_site) {
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
        document.getElementById("sites").value = id_site;
      }
    });
  });
};

/** Updates kind */
function setKinds(id_kind) {
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
      document.getElementById("kinds").value = id_kind;
    }
  });
};

/** Updates categorie of specific vehicle */
function setCategories(id_category) {
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
      document.getElementById("categories").value = id_category;
    }
  });
};

/** Updates state of specific vehicle */
function setStates(id_state) {
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
      document.getElementById("states").value = id_state;
    }
  });
};

/** Updates brand of specific vehicle */
function setBrands(id_brand) {
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
      document.getElementById('brand').value = id_brand;
    }
  });
}

/** Updates model of specific vehicle */
function setModels(id_model, id_brand) {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/models/" + id_brand,
    success: function(data) {
      var response = JSON.parse(data);
      var content = '';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_model + '">' + response[i].model + '</option>';
      }
      document.getElementById("model").innerHTML = content;
      document.getElementById("model").value = id_model;
    }
  });
}

/** Updates energy of specific vehicle */
function setEnergies(id_energy) {
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
      document.getElementById("energies").value = id_energy;
    }
  });
}

/** Updates equipment of specific vehicle */
function setEquipments(id_equipment) {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/equipments",
    success: function(data) {
      var response = JSON.parse(data);
      var content = '<option selected disabled>Equipements</option>';
      for (var i = 0; i < response.length; i++) {
        content = content + '<option value="' + response[i].id_equipment + '">' + response[i].equipment + '</option>';
      }
      document.getElementById("equipments").innerHTML = content;
      document.getElementById("equipments").value = id_equipment;
    }
  });
};

/** Deletes a selected vehicle */
function deleteVehicle() {
  var id = document.getElementById("listvehicles").value;
  $.ajax({
    method: "DELETE",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/" + id,
    success: function(data) {
      $(document).ready(function() {
        document.getElementById("vehicleblock").style.display = "none";
        getAllVehicles();
        $.toast({
          heading: "Success",
          text: "Vehicle successfully removed.",
          icon: "success"
        });
      });
    },
    error: function(xhr, status, error) {
      $(document).ready(function() {
        $.toast({
          heading: "Error",
          text: "",
          icon: "error"
        });
      });
    }
  });
}

/** Saves all changes for a vehicle */
function saveChangesVehicle() {
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
  var equipment = document.getElementById("equipments").value;
  var state = document.getElementById("states").value;
  var currency = document.getElementById("currencies").value;
  var site = document.getElementById("sites").value;
  var commentary = document.getElementById("commentary").value;

  $.ajax({
    method: "PUT",
    url: "http://think-parc.com/webservice/v1/companies/sites/" + site + "/vehicles/" + nr_plate + "/" + nr_serial +
      "/" + mileage + "/" + buyingprice + "/" + date_buy + "/" + date_entryservice + "/" + energy +
      "/" + model + "/" + kind + "/" + category + "/" + equipment + "/" + state + "/" + currency +
      "/" + commentary,
    success: function(data) {
      $(document).ready(function() {
        $.toast({
          heading: "Success",
          text: "Vehicle successfully updated.",
          icon: "success"
        });
      });
    },
    error: function(xhr, status, error) {
      $(document).ready(function() {
        $.toast({
          heading: "Error",
          text: "",
          icon: "error"
        });
      });
    }
  });
}

/** Good date format JJ/MM/AAAA */
function reformatDate(dateStr) {
  dArr = dateStr.split("-");
  return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
}