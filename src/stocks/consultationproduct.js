/**
 * consultationproduct.js
 *
 * @see consultationproduct.php
 * @author Said KHALID
 * @version 1.0
 */
$(function onLoad() {

   var id_company = document.getElementById('fct_id_company').innerHTML;
   document.getElementById("productblock").style.display = "none";
   getSites(id_company);
});



function getSites(id_company) {

   var id_company = document.getElementById('fct_id_company').innerHTML;

   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + id_company + "/sites",
      success: function(data) {

         var response = JSON.parse(data);
         var content = '<option selected disabled>Liste</option>';
         content = content + '<option value="0">Tous les sites</option>';

         for (var i = 0; i < response.length; i++) {
            content = content + '<option value="' + response[i].id_site + '">' + response[i].name + '</option>';
         }

         document.getElementById("listproducts").innerHTML = content;
      }
   });
};


function getsiteproduct(id_site, fct_id_company) {

   var fct_id_company = document.getElementById('fct_id_company').innerHTML;

   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/stocks/siteproduct/" + id_site + "/company/" + fct_id_company,
      success: function(data) {
         var response = JSON.parse(data);
         var dataSet = new Array(response.length);

         for (var i = 0; i < response.length; i++) {

            if (response[i].quanty == 0) {
               var quanty = "Rupture de stock";
            } else {

               var quanty = response[i].quanty + " " + response[i].measurement + "(s)";
            }

            if (typeof response[i].brand == '' && response[i].brand == 0)
            //if (response[i].brand.length == 0)
            {
               response[i].brand = "Aucune marque";
            }
            if (typeof response[i].comment == '' && response[i].comment == 0)
            //if (response[i].comment.length == 0)
            {
               response[i].comment = "Aucun commentaire";
            }

            if (typeof response[i].storehouse == '' && response[i].storehouse == 0)
            //if (response[i].storehouse.length == 0)
            {
               response[i].storehouse = "Aucun";
            }

            dataSet[i] = new Array(response[i].reference,
               response[i].designation,
               response[i].buyingprice + response[i].currency,
               response[i].company,
               response[i].family,
               quanty,
               response[i].driveway,
               response[i].bay,
               response[i].position,
               response[i].rack,
               response[i].site,
               response[i].typestock,
               response[i].locker,
               response[i].brand,
               response[i].comment,
               response[i].storehouse,
               '<a href="javascript:deletefromstock(' + response[i].id_stock + ');"><i id="icon_remove" class="fa fa-times"></i></a>');
         }

         document.getElementById("productblock").style.display = "block";

         $('#stock').html('<table cellspacing="0" width="100%" id="example"></table>');

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
               "title": "Designation",
               "class": "center fctbw"
            }, {
               "title": "Price",
               "class": "center fctbw"
            }, {
               "title": "Company",
               "class": "center fctbw"
            }, {
               "title": "Family",
               "class": "center fctbw"
            }, {
               "title": "Qte",
               "class": "center fctbw"
            }, {
               "title": "Bay",
               "class": "center fctbw"
            }, {
               "title": "Way",
               "class": "center fctbw"
            }, {
               "title": "Position",
               "class": "center fctbw"
            }, {
               "title": "Rack",
               "class": "center fctbw"
            }, {
               "title": "Site",
               "class": "center fctbw"
            }, {
               "title": "Type",
               "class": "center fctbw"
            }, {
               "title": "Locker",
               "class": "center fctbw"
            }, {
               "title": "Brand",
               "class": "center fctbw"
            }, {
               "title": "Coment",
               "class": "center fctbw"
            }, {
               "title": "Storehouse",
               "class": "center fctbw"
            }, {
               "title": "",
               "class": "center fctbw"
            }]
         });
      },
      error: function(data) {

      }
   });
};

function deletefromstock(id_stock) {
   $.ajax({
      method: "DELETE",
      url: "http://think-parc.com/webservice/v1/companies/stocks/deletefromstock/id_stock/" + id_stock,
      success: function(data) {
         $(document).ready(function() {
            //$.toast({heading: "Success",text: "Product successfully removed.", icon: "success"});
            alert("Suppression réussi");
            id_site = document.getElementById('listproducts').value;
            var id_company = document.getElementById('fct_id_company').innerHTML;
            getsiteproduct(id_site, id_company);
            //$('#example').DataTable().ajax.reload();
         });
      },
      error: function() {
         //$.toast({heading: "Error",text: "Error", icon: "error"});
         alert("Erreur");
      }
   });
}

/** End of file */