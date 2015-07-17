/**
 * accueil.js
 *
 * @see accueil.php
 * @author Joey BRONNER
 * @version 1.0
 */

/** AngularJS module for HTTP requests */
angular.module('HomeModule', []).controller('HomeController', function($scope, $http) {
  $scope.getRandomNews = function(data) {
    $http.get('http://think-parc.com/webservice/v1/news/random').
    success(function(data, status, headers, config) {
      var response = angular.fromJson(data);
      var content = '<h6>Posté par ' + response[0].firstname + ' ' + response[0].lastname + ' le ' + reformatDate(response[0].date_news) + '</h6>';
      content = content + '<h5>' + response[0].msg + '</h5>';
      document.getElementById("newsContent").innerHTML = content;
    });
  };
});

/* FUnction called on load home page (loading news) */
$(function onLoad() {
  // If any parameters exists to redirect to a specific section
  var section = getParameterByName('section');
  if (section != "") {
    changeSection("#" + section);
  }
  /* Load random news */
  angular.element($("#main-wrapper")).scope().getRandomNews();

  /* Load QuickView values */
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/vehicles/all",
      success: function(data) {
        var response1 = JSON.parse(data);
        var totalvehicles = response1.length;
        /* Retrieve maintenance state */
        $.ajax({
          method: "GET",
          url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/vehicles/currentlyinmaintenance",
          success: function(data) {
            var response2 = JSON.parse(data);
            var vehiclesmaintenance = response2.length;
            document.getElementById("qv_vehicles_maint").innerHTML = vehiclesmaintenance + "/" + totalvehicles;
            if ((vehiclesmaintenance / totalvehicles) * 100 > 50) {
              document.getElementById("qv_vehicles_maint").style.color = 'red';
            } else if ((vehiclesmaintenance / totalvehicles) * 100 > 10) {
              document.getElementById("qv_vehicles_maint").style.color = 'orange';
            } else {
              document.getElementById("qv_vehicles_maint").style.color = 'green';
            }
          }
        });
      }
    });
    /* Retrieve trasfert state */
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/stocks/gettransferlist/company/" + company,
      success: function(data) {
        var response = JSON.parse(data);
        document.getElementById("qv_transfert_wait").innerHTML = response.length;
        if (response.length > 0) {
          document.getElementById("qv_transfert_wait").style.color = 'red';
        } else {
          document.getElementById("qv_transfert_wait").style.color = 'green';
        }
      }
    });
    /* Retrieve insurances state */
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/insurances/alert",
      success: function(data) {
        var response = JSON.parse(data);
        document.getElementById("qv_assurances_end").innerHTML = response.length;
        if (response.length > 0) {
          document.getElementById("qv_assurances_end").style.color = 'red';
        } else {
          document.getElementById("qv_assurances_end").style.color = 'green';
        }
      }
    });
    /* Retrieve technical control state */
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/reporting/technicalcontrol/alert",
      success: function(data) {
        var response = JSON.parse(data);
        document.getElementById("qv_techcontrol_end").innerHTML = response.length;
        if (response.length > 0) {
          document.getElementById("qv_techcontrol_end").style.color = 'red';
        } else {
          document.getElementById("qv_techcontrol_end").style.color = 'green';
        }
      }
    });
  });
});

/** Good date format JJ/MM/AAAA */
function reformatDate(dateStr) {
  dArr = dateStr.split("-");
  return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
}

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

/** Retrieves parameter on page loading (performed with back button) */
function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}