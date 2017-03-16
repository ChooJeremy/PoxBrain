function sendresetpassword() {
  $.ajax("/accounts/resetpassword.php", {
    data: {
        "email": $("#password-reset-email").val()
    },
    type: "POST",
    success: function(data, textStatus, jqXHR) {
        if(data == "OK") {
            //success
            //user now needs to verify email
            $("#email-reset-result")[0].innerHTML = "OK, we've sent you an email. Follow the steps in that email to recover your password.";
        } else {
            //error
            $("#email-reset-result")[0].innerHTML = data;
        }
    }, 
    error: function(jqXHR, textStatus, data) {
      $("#email-reset-result")[0].innerHTML = data;
    }
  });
    if(ga !== undefined) //user does not have ga disabled to some script blocker
  {
      ga("send", "pageview", "/accounts/resetpassword.php");
  }    
  return false;
}
function sendresetpasswordrequest() {
  if($("#password-reset-field").val() !== $("#password-reset-confirm").val()) {
    alert("The two passwords do not match");
    return false;
  }
  $.ajax("/accounts/resetpassword.php", {
    data: {
      "password": $("#password-reset-field").val(),
      "selector": $("#selector").val(),
      "token": $("#token").val()
    },
    type: "POST",
    success: function(data, textStatus, jqXHR) {
        if(data === "OK") {
            $("#password-reset-result")[0].innerHTML = "Your password has been successfully reset. You can <a onclick='enableLogin()'>log in</a> now.";
        } else {
            $("#password-reset-result")[0].innerHTML = data;
        }
    }
  })
  if(ga !== undefined) //user does not have ga disabled to some script blocker
  {
      ga("send", "pageview", "/accounts/resetpassword.php");
  }
  return false;
}
function passwordResetCheck() {
  if($("#password-reset-field").val() == "" || $("#password-reset-confirm").val() == "") {
    $("#reset-password-match").addClass("hide");
    return;
  }
  if($("#password-reset-field").val() !== $("#password-reset-confirm").val()) {
      $("#reset-password-match").removeClass("hide");
  } else {
      $("#reset-password-match").addClass("hide");
  }

}
$(document).ready(function() {
  $("#password-reset-field, #password-reset-confirm").on("blur", passwordResetCheck);
});