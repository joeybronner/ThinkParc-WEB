/**
 * addsite.js
 *
 * @see addsite.php
 * @author Said KHALID
 * @version 1.0
 */
/** Method called on page loading */
$(function onLoad() {
   getcompany();
});

/** Allows to add a new site for one company */
function addsite(id_company, name, adress1, adress2, adress3, city, country) {

   var id_company = document.getElementById("id_company").value;
   var name = document.getElementById("name").value;
   var adress1 = document.getElementById("adress1").value;
   var adress2 = document.getElementById("adress2").value;
   var adress3 = document.getElementById("adress3").value;
   var city = document.getElementById("city").value;
   var country = document.getElementById("country").value;

   $.ajax({

      type: "POST",
      url: "http://www.think-parc.com/webservice/v1/companies/options/addsite/name/" + name + "/id_company/" + id_company + "/adress1/" + adress1 + "/adress2/" + adress2 + "/adress3/" + adress3 + "/city/" + city + "/country/" + country,
      success: function(data) {
         document.getElementById("addsite").reset();
         $(document).ready(function() {
            $.toast({
               heading: "Success",
               text: "Site successfully added.",
               icon: "success"
            });
         });

      },
      error: function(xhr, status, error) {
         $(document).ready(function() {
            $.toast({
               heading: "Error",
               text: "Error",
               icon: "error"
            });
         });
      }
   });

};



/** Allows to get all companies on a list */
function getcompany() {

   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/options/getcompany",
      success: function(data) {
         var response = JSON.parse(data);
         var content = '<option selected disabled>Company</option>';
         for (var i = 0; i < response.length; i++) {
            content = content + '<option value="' + response[i].id_company + '">' + response[i].name + '</option>';
         }
         document.getElementById("id_company").innerHTML = content;

      }
   });
};

/** End of file */