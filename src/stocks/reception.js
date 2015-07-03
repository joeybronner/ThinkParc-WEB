/**
 * reception.js
 *
 * @see reception.php
 * @author Said KHALID
 * @version 1.0
 */
var id_company = document.getElementById('fct_id_company').innerHTML;
var size;
var myquanty = [];
var idtransfert = [];
var idpart = [];
var measure = [];
var title = [];
var type = [];
var storehouse = [];
var thereceiver = [];

$(function onLoad() {
   var id_company = document.getElementById('fct_id_company').innerHTML;
   gettransferlist(id_company);
   document.getElementById("transferblock").style.display = "none";
});

function gettransferlist(id_company) {

   var id_company = document.getElementById('fct_id_company').innerHTML;

   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/stocks/gettransferlist/company/" + id_company,
      success: function(data) {

         var response = JSON.parse(data);
         var content = '<option selected disabled>List</option>';

         for (var i = 0; i < response.length; i++) {
            content = content + '<option value="' + response[i].title + '"> date : ' + response[i].transferdate + ' --- libellé : ' + response[i].title + ' </option>';
         }

         document.getElementById("transfertlist").innerHTML = content;

      }
   });
};

function getblock() {
   document.getElementById("transferblock").style.display = "block";
   getsitecompany(id_company);
};

function hideblock() {
   document.getElementById("transferblock").style.display = "none";
   gettransferlist(id_company);
};


function receptioncheck() {

   var thesize = window.size;
   var exec;
   var id_company = document.getElementById('fct_id_company').innerHTML;
   total = 0;

   for (var i = 0; i <= thesize; i++) {

      var driveway = document.getElementById('driveway' + i).value;
      var locker = document.getElementById('locker' + i).value;
      var rack = document.getElementById('rack' + i).value;
      var position = document.getElementById('position' + i).value;
      var bay = document.getElementById('bay' + i).value;
      var idtrans = window.idtransfert[i];
      var idpart = window.idpart[i];
      var myquanty = window.myquanty[i];
      var type = window.type[i];
      var storehouse = window.storehouse[i];
      var thereceiver = window.thereceiver[i];
      var measure = window.measure[i];
      var title = window.title[i];


      if (storehouse == undefined) {
         storehouse = "Aucun";
      }

      if (driveway != '' && locker != '' && rack != '' && position != '' && bay != '' && thereceiver != '' && idpart != '' && idtrans != '' && myquanty != '') {
         total++;
         TransfertProductInStock(idtrans, idpart, driveway, bay, position, rack, locker, myquanty, thereceiver, type, measure, storehouse);
         exec = true;
         hideblock();
      } else {
         exec = false;
      }

   }

   total = 0;

   if (!exec) {
      $.toast({
         heading: "Error",
         text: "Error",
         icon: "error"
      });
   }


}

function isInt(value) {
   return !isNaN(value) && (function(x) {
      return (x | 0) === x;
   })(parseFloat(value))
}


function TransfertProductInStock(idtrans, idpart, driveway, bay, position, rack, locker, myquanty, thereceiver, type, measure, storehouse) {


   $.ajax({
      method: "POST",
      url: "http://think-parc.com/webservice/v1/companies/stocks/idtransfert/" + idtrans + "/quanty/" + myquanty + "/idpart/" + idpart + "/driveway/" + driveway + "/bay/" + bay + "/position/" + position + "/rack/" + rack + "/locker/" + locker + "/receiver/" + thereceiver + "/type/" + type + "/measure/" + measure + "/storehouse/" + storehouse,
      success: function() {
         $.toast({
            heading: "Success",
            text: "Product(s) successfully transfered in stock.",
            icon: "success"
         });
         gettransferlist(id_company);
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


function getsitecompany(id_company) {


   var id_company = document.getElementById('fct_id_company').innerHTML;

   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/stocks/sitecompany/" + id_company,
      success: function(data) {

         var response = JSON.parse(data);
         var content = '<option selected disabled>Choisir site</option>';

         for (var i = 0; i < response.length; i++) {
            content = content + '<option value="' + response[i].id_site + '">' + response[i].name + '</option>';
         }

         document.getElementById("idsite").innerHTML = content;

      }
   });
};


function getalltransferts(fct_id_user, title) {

   getblock();
   getsitecompany(id_company);

   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/stocks/getalltransferts/company/" + id_company + "/title/" + title,
      success: function(data) {

         var response = JSON.parse(data);
         var dataSet = new Array(response.length);
         idtransfert = new Array(response.length);
         idpart = new Array(response.length);
         myquanty = new Array(response.length);
         type = new Array(response.length);
         measure = new Array(response.length);
         title = new Array(response.length);
         thereceiver = new Array(response.length);

         for (var i = 0; i < response.length; i++) {

            dataSet[i] = new Array(response[i].title,
               response[i].quantity,
               response[i].reference,
               response[i].transferdate,
               response[i].receivername,
               '<input type="text" id="driveway' + i + '" class="small"></input>',
               '<input type="text" id="bay' + i + '" class="small"></input>',
               '<input type="text" id="position' + i + '" class="small"></input>',
               '<input type="text" id="rack' + i + '" class="small"></input>',
               '<input type="text" id="locker' + i + '" class="small"></input>',
               '<input type="text" id="storehouse' + i + '" class="small"></input>');


            size = i;
            idtransfert[i] = response[i].id_transfert;
            idpart[i] = response[i].id_part;
            myquanty[i] = response[i].quantity;
            type[i] = response[i].typestock;
            measure[i] = response[i].measurement;
            title[i] = response[i].title;
            thereceiver[i] = response[i].receiver;
         }


         $('#transfert').html('<table  cellspacing="0" width="100%" id="example"></table>');

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
               "title": "Libelle",
               "class": "center fctbw"
            }, {
               "title": "Qte",
               "class": "center fctbw"
            }, {
               "title": "Ref>",
               "class": "center fctbw"
            }, {
               "title": "Date",
               "class": "center fctbw"
            }, {
               "title": "Destinataire",
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
               "title": "Drive",
               "class": "center fctbw"
            }, {
               "title": "Store House",
               "class": "center fctbw"
            }]
         });
      },
      error: function(data) {
         //alert('error');
      }
   });
};

/** End of file */