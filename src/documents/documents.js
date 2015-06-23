/**
 * documents.js
 *
 * @see documents.php
 * @author Joey Bronner
 * @version 1.0
 */
 
/** Global public variables used and re-used in some methods */
var typeFile = 4;

/** Method called on page loading */
$(function onLoad() {
  getFiles();
});

/** Removes a file by ID */
function removeFile(id_file) {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/files/" + id_file + "/path",
    success: function(data) {
      var response = JSON.parse(data);
      var path = response[0].path;
      var formData = new FormData();
      formData.append('path', path);
      var xhr = new XMLHttpRequest();
      xhr.open('POST', '../../files/removefile.php?target=global_company', true);
      xhr.onload = function() {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            $.ajax({
              method: "DELETE",
              url: "http://think-parc.com/webservice/v1/files/" + id_file,
              success: function(data) {
                var response = JSON.parse(data);
                getFiles();
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

/** Downloads a file by ID */
function downloadFile(id_file) {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/files/" + id_file + "/path",
    success: function(data) {
      var response = JSON.parse(data);
      window.open('../../files/global_company/' + response[0].path);
    }
  });
}

/** Retrieves all files */
function getFiles() {
  var sTypeFile = "";
  switch (typeFile) {
    case 1:
      sTypeFile = "vehicles";
      break;
    case 2:
      sTypeFile = "technical";
      break;
    case 4:
      sTypeFile = "global";
      break;
  }
  getCompany(function(company) {
    $.ajax({
      method: "GET",
      url: "http://think-parc.com/webservice/v1/companies/" + company + "/files/" + sTypeFile,
      success: function(data) {
        var response = JSON.parse(data);
        var dataSet = new Array(response.length);
        for (var i = 0; i < response.length; i++) {
          var ext = "." + response[i].path.substr(response[i].path.lastIndexOf('.') + 1);
          var logo = "fa fa-file-o";
          if (ext == ".xls" || ext == ".xlsx") {
            logo = "fa fa-file-excel-o";
          } else if (ext == ".pdf") {
            logo = "fa fa-file-pdf-o";
          } else if (ext == ".png" || ext == ".jpg" || ext == ".jpeg") {
            logo = "fa fa-file-image-o";
          } else if (ext == ".doc" || ext == ".docx") {
            logo = "fa fa-file-word-o";
          }

          dataSet[i] = new Array(reformatDate(response[i].date_upload),
            '<i class="' + logo + '"></i>',
            response[i].path,
            '<a href="javascript:removeFile(' + response[i].id_file + ');"><i class="fa fa-times"></i></a>',
            '<a href="javascript:downloadFile(' + response[i].id_file + ');"><i class="fa fa-download"></i></a>');
        }

        $('#documents').html('<table class="display" id="listoffiles"></table>');

        $('#listoffiles').dataTable({
          "data": dataSet,
          "scrollX": true,
          "bPaginate": true,
          "aLengthMenu": [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
          ],
          "bLengthChange": true,
          "bStateSave": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": true,
          "fnInitComplete": function(oSettings, json) {
            $(".dataTables_length select").addClass("datatables-select");
            $(".dataTables_filter input").addClass("datatables-input");
          },
          "columns": [{
            "title": "Date",
            "class": "center fctbw"
          }, {
            "title": "Type",
            "class": "center fctbw"
          }, {
            "title": "Fichier",
            "class": "center fctbw"
          }, {
            "title": "",
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

/** Upload a new file */
function uploadFile() {
  var file = document.getElementById('file-select').files[0];
  var formData = new FormData();

  // Check the file type.
  var fakepath = document.getElementById("file-select").value;
  var ext = "." + fakepath.substr(fakepath.lastIndexOf('.') + 1);
  if (!file.type.match('.pdf') &&
    !file.type.match('.doc') &&
    !file.type.match('.docx') &&
    !file.type.match('.png') &&
    !file.type.match('.xls') &&
    !file.type.match('.xlsx') &&
    !file.type.match('.ppt') &&
    !file.type.match('.pptx') &&
    !file.type.match('.jpg') &&
    !file.type.match('.jpeg')) {
    $(document).ready(function() {
      $.toast({
        heading: "Error",
        text: "Only Excel, Powerpoint, Pictures, PDF and Documents are supported.",
        icon: "error"
      });
    });
  } else {
    // Add file to data form
    var d = new Date();
    var generatedfilename = d.getTime() + "_" + file.name;
    formData.append('myfiles', file, generatedfilename);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "../../files/uploadfile.php?target=global_company", true);
    xhr.onload = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          $(document).ready(function() {
            getCompany(function(company) {
              $.ajax({
                method: "POST",
                url: "http://think-parc.com/webservice/v1/files/new/4/" + generatedfilename + "/" + company,
                success: function(data) {
                  $(document).ready(function() {
                    $('#file-form').each(function() {
                      this.reset();
                    });
                    getFiles();
                    // Reset fields
                    document.getElementById("file-select").value = "";
                    cancelAddFile();
                    $.toast({
                      heading: "Success",
                      text: "File successfully uploaded.",
                      icon: "success"
                    });
                  });
                },
                error: function(xhr, status, error) {
                  $(document).ready(function() {
                    cancelAddFile();
                    $.toast({
                      heading: "Error",
                      text: "",
                      icon: "error"
                    });
                  });
                }
              });
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

/** Shows news fields  */
function showNewFileFields() {
  document.getElementById("file-form").style.display = "block";
  document.getElementById("manageFile").href = "javascript:hideNewFileFields()";
  document.getElementById("iconManageFile").className = "fa fa-minus-circle";
}

/** Hides fields used to upload a new file */
function hideNewFileFields() {
  document.getElementById("file-form").style.display = "none";
  document.getElementById("manageFile").href = "javascript:showNewFileFields()";
  document.getElementById("iconManageFile").className = "fa fa-plus-circle";
}

/** Display global tab */
function displayGlobal() {
  $('#tab-global').addClass('active');
  $('#tab-vehicles').removeClass('active');
  $('#tab-technical').removeClass('active');
  typeFile = 4;
  getFiles();
}

/** Display technical tab */
function displayTechnical() {
  $('#tab-global').removeClass('active');
  $('#tab-vehicles').removeClass('active');
  $('#tab-technical').addClass('active');
  typeFile = 2;
  getFiles();
}

/** Display vehicles tab */
function displayVehicles() {
  $('#tab-global').removeClass('active');
  $('#tab-vehicles').addClass('active');
  $('#tab-technical').removeClass('active');
  typeFile = 1;
  getFiles();
}

/** Reformates a date in JJ/MM/AAAA format */
function reformatDate(dateStr) {
  dArr = dateStr.split("-");
  return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
}

/** Cancels and hides popup form */
function cancelAddFile() {
  popup('custompopup');
}