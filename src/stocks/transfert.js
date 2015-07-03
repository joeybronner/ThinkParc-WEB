/**
 * transfert.js
 *
 * @see transfert.php
 * @author Said KHALID
 * @version 1.0
 */
var idstock = [];
var quanty = [];
var myref = [];
var type = [];
var measure = [];
var size;
var total = 0;
var test;

$(function onLoad() {
   var id_company = document.getElementById('fct_id_company').innerHTML;
   document.getElementById("productblock").style.display = "none";
   document.getElementById("stock").style.display = "none";
   getSites(id_company);
   getsiteproduct(id_company);
});



function getsiteproduct(id_company) {

   var id_company = document.getElementById('fct_id_company').innerHTML;

   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + id_company + "/sites",
      success: function(data) {

         var response = JSON.parse(data);
         var content = '<option selected disabled>Site</option>';

         for (var i = 0; i < response.length; i++) {
            content = content + '<option value="' + response[i].id_site + '">' + response[i].name + '</option>';
         }

         document.getElementById("listproducts2").innerHTML = content;

      }
   });
};


function getblock() {
   document.getElementById("productblock").style.display = "block";
   document.getElementById("stock").style.display = "block";
};


function check() {

   var thesize = window.size;
   var exec = false;
   var productnumber;
   var idsite = document.getElementById('listproducts').value;
   var title = document.getElementById('title').value;
   total = 0;


   if (title == "") {
      title = "Sans titre";
   }

   for (var i = 0; i <= thesize; i++) {
      var ref = window.myref[i];
      var ids = idstock[i];
      var quantity = window.myquanty[i];
      var type = window.type[i];
      var measure = window.measure[i];
      productnumber = document.getElementById('productnumber' + i).value;

      if (productnumber > 0) {
         total++;
         TransfertProduct(ref, i, productnumber, ids, quantity, type, measure, title);
         exec = true;
      }

   }

   total = 0;
   var id_company = document.getElementById('fct_id_company').innerHTML;

   if (exec) {
      getcompanyproduct(id_company, idsite);
   } else {
      $.toast({
         heading: "Error",
         text: "Error in the Check Ref",
         icon: "error"
      });
   }

}


function TransfertProduct(ref, i, productnumber, idstock, quantity, type, measure, title) {

   var productnumber = document.getElementById('productnumber' + i).value;
   var id_site2 = document.getElementById('listproducts2').value;
   var idsite = document.getElementById('listproducts').value;

   if (quantity < parseInt(productnumber)) {
      //alert('Erreur');
      getcompanyproduct(id_company, idsite);
      return false;
   }

   $.ajax({
      method: "POST",
      url: "http://think-parc.com/webservice/v1/companies/stocks/ref/" + ref + "/quanty/" + productnumber + "/secondsite/" + id_site2 + "/idstock/" + idstock + "/type/" + type + "/measure/" + measure + "/title/" + title,
      success: function() {
         $.toast({
            heading: "Success",
            text: "Product(s) successfully transfered.",
            icon: "success"
         });
         getcompanyproduct(id_company, idsite);
      },
      error: function() {
         $.toast({
            heading: "Error",
            text: "Error",
            icon: "error"
         });
      }
   });

}


function getcompanyproduct(fct_id_company, idsite) {
   getblock();
   var idsite = document.getElementById('listproducts').value;
   var id_company = document.getElementById('fct_id_company').innerHTML;


   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/stocks/companyproduct/company/" + id_company + "/idsite/" + idsite,
      success: function(data) {

         var response = JSON.parse(data);
         var dataSet = new Array(response.length);
         myref = new Array(response.length);
         myquanty = new Array(response.length);
         type = new Array(response.length);
         measure = new Array(response.length);

         for (var i = 0; i < response.length; i++) {
            idstock[i] = response[i].id_stock;

            if (response[i].quanty == 0) {
               var quanty = "Rupture de stock";
            } else {

               var quanty = response[i].quanty + " " + response[i].measurement + "(s)";
            }


            dataSet[i] = new Array(response[i].reference,
               quanty,
               response[i].driveway,
               response[i].bay,
               response[i].position,
               response[i].rack,
               response[i].locker,
               response[i].site,
               '<input type="text" id="productnumber' + i + '" class="small" placeholder="qte"></input>');

            size = i;
            myref[i] = response[i].id_part;
            myquanty[i] = response[i].quanty;
            type[i] = response[i].id_typestock;
            measure[i] = response[i].id_measurement;



         }

         document.getElementById("productblock").style.display = "block";

         $('#stock').html('<table  cellspacing="0" width="100%" id="example"></table>');

         var table = $('#example').dataTable({
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
               "title": "Quanty",
               "class": "center fctbw"
            }, {
               "title": "Drive",
               "class": "center fctbw"
            }, {
               "title": "Bay",
               "class": "center fctbw"
            }, {
               "title": "Position",
               "class": "center fctbw"
            }, {
               "title": "Rack",
               "class": "center fctbw"
            }, {
               "title": "Locker",
               "class": "center fctbw"
            }, {
               "title": "Site",
               "class": "center fctbw"
            }, {
               "title": "Qte",
               "class": "center fctbw"
            }]
         });
      },
      error: function(data) {

      }
   });
};


function getSites(id_company) {

   var id_company = document.getElementById('fct_id_company').innerHTML;

   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + id_company + "/sites",
      success: function(data) {

         var response = JSON.parse(data);
         var content = '<option selected disabled>Site</option>';

         for (var i = 0; i < response.length; i++) {
            content = content + '<option value="' + response[i].id_site + '">' + response[i].name + '</option>';
         }

         document.getElementById("listproducts").innerHTML = content;

      }
   });
};


function getSites2(id_site) {

   var id_company = document.getElementById('fct_id_company').innerHTML;



   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + id_company + "/site/" + id_site + "/sites2",
      success: function(data) {

         var response = JSON.parse(data);
         var content = '<option selected disabled>Site</option>';

         for (var i = 0; i < response.length; i++) {
            content = content + '<option value="' + response[i].id_site + '">' + response[i].name + '</option>';
         }

         document.getElementById("listproducts2").innerHTML = content;
      }
   });
};

/** End of file */