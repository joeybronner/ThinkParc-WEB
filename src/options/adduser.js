/**
 * adduser.js
 *
 * @see adduser.php
 * @author Said KHALID
 * @version 1.0
 */
/** Method called on page loading (load two methods) */
$(function onLoad() {
   getcompany();
   getroles();
});

/** Allows to add a new user for one company */
function adduser(firstname, lastname, login, password, email, image, id_role, id_company) {

   var firstname = document.getElementById("firstname").value;
   var lastname = document.getElementById("lastname").value;
   var login = document.getElementById("login").value;
   var password = CryptoJS.MD5(document.getElementById("password").value).toString();
   var passconfirmation = CryptoJS.MD5(document.getElementById("passwordconfirmation").value).toString();
   var email = document.getElementById("email").value;
   var image = document.getElementById("image").value;
   var id_company = document.getElementById("id_company").value;
   var id_role = document.getElementById("id_role").value;

   if (image == "") {
      image = "NULL";
   } else {

      var file = document.getElementById('image').files[0];
      var formData = new FormData();

      // Check the file type.
      var fakepath = document.getElementById("image").value;
      var ext = "." + fakepath.substr(fakepath.lastIndexOf('.') + 1);
      if (!file.type.match('image.*')) {
         $(document).ready(function() {
            $.toast({
               heading: "Error",
               text: "Only pictures are supported.",
               icon: "error"
            });
         });
      } else {
         // Add file to data form
         var d = new Date();
         var generatedfilename = d.getTime() + "_" + file.name;
         formData.append('myfiles', file, generatedfilename);
         var xhr = new XMLHttpRequest();
         xhr.open('POST', '../../files/uploadfile.php?target=img_users', true);
      }
      xhr.send(formData);
   }

   if (password != passconfirmation) {
      $(document).ready(function() {
         $.toast({
            heading: "Error",
            text: "New password and confirmation are not identical.",
            icon: "error"
         });
      });

   } else if (!validateEmail(email)) {
      $(document).ready(function() {
         $.toast({
            heading: "Error",
            text: "Please enter a valid email.",
            icon: "error"
         });
      });


   } else {
      $.ajax({

         type: "POST",
         url: "http://www.think-parc.com/webservice/v1/companies/options/adduser/" + firstname + "/lastname/" + lastname + "/login/" + login + "/password/" + password + "/email/" + email + "/image/" + generatedfilename + "/id_role/" + id_role + "/id_company/" + id_company,
         success: function(data) {
            $(document).ready(function() {
               document.getElementById("adduser").reset();
               $.toast({
                  heading: "Success",
                  text: "User successfully added.",
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

   }

};


/** Allows to get all company */
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


/** Allows to get all user roles */
function getroles() {

   $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/options/getroles",
      success: function(data) {
         var response = JSON.parse(data);
         var content = '<option selected disabled>Roles</option>';
         for (var i = 0; i < response.length; i++) {
            content = content + '<option value="' + response[i].id_role + '">' + response[i].role + '</option>';
         }
         document.getElementById("id_role").innerHTML = content;

      }
   });
};

/** Allows to validate email input */
function validateEmail(email) {
   var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
   return re.test(email);
}

/** End of file */