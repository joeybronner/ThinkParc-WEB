/**
 * docsadministratives.js
 *
 * @see docsadministratives.php
 * @author Joey Bronner
 * @version 1.0
 */

 /** Method called on page loading */
 $(function onLoad() {
  displayVehicles();
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

/** Displays all vehicles in a datatable */
function displayVehicles() {
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/all",
      success: function(data) {
        var response = JSON.parse(data);
        var dataSet = new Array(response.length);
        for (var i = 0; i < response.length; i++) {
          dataSet[i] = new Array(response[i].nr_plate,
            response[i].nr_serial,
            response[i].mileage,
            response[i].buyingprice,
            response[i].energy,
            response[i].brand,
            response[i].model,
            response[i].kind,
            response[i].category,
            response[i].equipments,
            response[i].state,
            response[i].name,
            response[i].commentary,
            '<a href="javascript:deleteVehicle(' + response[i].id_vehicle + ');"><i id="icon_remove" class="fa fa-times"></i></a>');
        }

        $('#vehicles').html('<table class="display" cellspacing="0" width="100%" id="example"></table>');

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
            "title": "Immatriculation",
            "class": "center fctbw"
          }, {
            "title": "N° de série",
            "class": "center fctbw"
          }, {
            "title": "Kilométrage",
            "class": "center fctbw"
          }, {
            "title": "Prix d'achat",
            "class": "center fctbw"
          }, {
            "title": "Carburant",
            "class": "center fctbw"
          }, {
            "title": "Marque",
            "class": "center fctbw"
          }, {
            "title": "Modèle",
            "class": "center fctbw"
          }, {
            "title": "Type",
            "class": "center fctbw"
          }, {
            "title": "Catégorie",
            "class": "center fctbw"
          }, {
            "title": "Equipement(s)",
            "class": "center fctbw"
          }, {
            "title": "Etat",
            "class": "center fctbw"
          }, {
            "title": "Site",
            "class": "center fctbw"
          }, {
            "title": "Commentaire",
            "class": "center fctbw"
          }, {
            "title": "",
            "class": "center fctbw"
          }]
        });
      }
    });
  });
}

/** Deletes a vehicle with a specific ID */
function deleteVehicle(id_vehicle) {
  $.ajax({
    method: "DELETE",
    url: "http://think-parc.com/webservice/v1/companies/vehicles/" + id_vehicle,
    success: function(data) {
      $(document).ready(function() {
        displayVehicles()
      });
    }
  });
}