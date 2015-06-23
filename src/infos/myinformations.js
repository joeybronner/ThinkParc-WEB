/**
 * myinformations.js
 *
 * @see myinformations.php
 * @author Joey Bronner
 * @version 1.0
 */
 
/** Method called on page loading */
$(function onLoad() {
  getUserInfos();
  getNews();
});

/** Retrieves all user's informations */
function getUserInfos() {
  var id_user = document.getElementById("id_user").innerText;
  $.ajax({
    type: "GET",
    url: "http://www.think-parc.com/webservice/v1/companies/users/" + id_user,
    success: function(data) {
      var response = JSON.parse(data);
      document.getElementById("firstname").innerText = response[0].firstname;
      document.getElementById("lastname").innerText = response[0].lastname;
      document.getElementById("login").innerText = response[0].login;
      document.getElementById("email").innerText = response[0].email;
      document.getElementById("image").innerText = response[0].image;
      document.getElementById("userpic").src = "../../files/img_users/" + response[0].image;
    }
  });
}

/** Updates user's password */
function updatePassword(id) {
  // Check if all fields are completed
  var oldpass = document.getElementById("oldpass").value;
  var newpass = document.getElementById("newpass").value;
  var confpass = document.getElementById("confpass").value;
  if (oldpass === "" || newpass === "" || confpass === "") {
    $(document).ready(function() {
      $.toast({
        heading: "Error",
        text: "All fields are required to change your password.",
        icon: "error"
      });
    });
  } else if (newpass != confpass) {
    $(document).ready(function() {
      $.toast({
        heading: "Error",
        text: "New password and confirmation are not identical.",
        icon: "error"
      });
    });
  } else {
    // Check old password
    $.ajax({
      type: "GET",
      url: "http://www.think-parc.com/webservice/v1/companies/users/" + id,
      success: function(data) {
        var response = JSON.parse(data);
        if (response[0].pass === oldpass) {
          // Update new password
          $.ajax({
            type: "GET",
            url: "http://www.think-parc.com/webservice/v1/companies/users/password/update/" + id + "/" + newpass,
            success: function(data) {
              $(document).ready(function() {
                document.getElementById("formpassword").reset();
                $.toast({
                  heading: "Success",
                  text: "Password successfully updated.",
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
        } else {
          $(document).ready(function() {
            $.toast({
              heading: "Error",
              text: "Your old password is not correct.",
              icon: "error"
            });
          });
        }
      }
    });
  }
}

/** Uploads a new file (profile picture) */
function uploadFile(id_user) {
  var file = document.getElementById('file-select').files[0];
  var formData = new FormData();

  // Check the file type.
  var fakepath = document.getElementById("file-select").value;
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
    xhr.onload = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          $(document).ready(function() {
            $.ajax({
              method: "PUT",
              url: "http://think-parc.com/webservice/v1/companies/users/" + id_user + "/profilepicture/" + generatedfilename + ext,
              success: function(data) {
                $(document).ready(function() {
                  $('#file-form').each(function() {
                    this.reset();
                  });
                  getUserInfos();
                  $.toast({
                    heading: "Success",
                    text: "Picture successfully uploaded.",
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

/** eformates a date in french format JJ/MM/AAAA */
function reformatDate(dateStr) {
  dArr = dateStr.split("-");
  return dArr[2] + "/" + dArr[1] + "/" + dArr[0];
}

/** Retrieves all news posted by super administrator (Slimane) */
function getNews() {
  $.ajax({
    method: "GET",
    url: "http://think-parc.com/webservice/v1/news/all",
    success: function(data) {
      var response = JSON.parse(data);
      var content = '<table class="table" style="width:100%;font-size:12px;">';
      for (var i = 0; i < response.length; i++) {
        var news = response[i];
        content += '<tr>';
        content += '<td>' + reformatDate(news.date_news) + '<td>';
        content += '<td>' + news.msg + '<td>';
        if (news.active == 1) {
          content += '<td><input id="' + news.id_news + '" name="post_actif_' + news.id_news + '" type="checkbox" onclick="updateNewsStatus(' + news.id_news + ', 0);" checked></td>';
        } else {
          content += '<td><input id="' + news.id_news + '" name="post_actif_' + news.id_news + '" type="checkbox" onclick="updateNewsStatus(' + news.id_news + ', 1);"></td>';
        }
        content += '<td><a href="javascript:deleteNews(' + news.id_news + ');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>';
        content += '</tr>';
      }
      content += '</table>';
      document.getElementById("post_actif_").innerHTML = content;
    }
  });
};

/** Updates a news status (ON/OFF) */
function updateNewsStatus(id, status) {
  $.ajax({
    type: "GET",
    url: "http://www.think-parc.com/webservice/v1/news/" + id + "/status/" + status,
    success: function(data) {
      $(document).ready(function() {
        $.toast({
          heading: "Success",
          text: "News successfully updated.",
          icon: "success"
        });
      });
      getNews();
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

/** Deletes a news into the database (definitely) */
function deleteNews(id) {
  $.ajax({
    type: "GET",
    url: "http://www.think-parc.com/webservice/v1/news/" + id + "/delete",
    success: function(data) {
      $(document).ready(function() {
        $.toast({
          heading: "Success",
          text: "News successfully removed.",
          icon: "success"
        });
      });
      getNews();
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

/** Adds a news into the database (automatically ON) */
function addNews(id) {
  var newstext = document.getElementById("newstext").value;
  $.ajax({
    type: "GET",
    url: "http://www.think-parc.com/webservice/v1/news/add/" + id + "/" + newstext,
    success: function(data) {
      $(document).ready(function() {
        $.toast({
          heading: "Success",
          text: "News successfully added.",
          icon: "success"
        });
      });
      getNews();
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
  sessionStorage.removeItem("newstext");
};