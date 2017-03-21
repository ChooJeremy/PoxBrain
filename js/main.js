function enableLogin() {
    $("#login-signup").css("display", "block");
    $("#dim").css("display", "block");
    $("#account-result")[0].innerHTML = "";
}
function disableLogin() {
    $("#login-signup").css("display", "none");
    $("#dim").css("display", "none");
    $("#account-result")[0].innerHTML = "";
}
function enableCollectionHelp() {
    $("#collection-help").css("display", "block");
    $("#dim").css("display", "block");
}
function disableCollectionHelp() {
    $("#collection-help").css("display", "none");
    $("#dim").css("display", "none");
}
function performLogin() {
    $.ajax("/accounts/login.php", {
        data: {
            "email": $("#login-email").val(),
            "password": $("#login-password").val(),
            "remember": $("#login-remember")[0].checked ? 1 : 0
        },
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            if(data == "OK") {
                $("#account-result")[0].innerHTML = "You have successfully logged in! Now refreshing the page...";
                //success, refresh page
                trashDB(function() {
                    if(window.location.pathname.substring(0, 13) == "/verify_email") { //If I'm on the verify email page, don't re-show the page
                    //instead redirect to the home page, no point re-showing the verify email page. {
                        location.href = "/";
                    } else {
                        location.reload();
                    }
                });
            } else {
                //error
                $("#account-result")[0].innerHTML = data;
            }
        }
    });
    if(ga !== undefined) //user does not have ga disabled to some script blocker
    {
        ga("send", "pageview", "/accounts/login.php");
    }
    return false;
}
function performRegister() {
    if($("#register-password-confirm").val() !== $("#register-password").val()) {
        alert("Passwords do not match. Please try again.");
        return false;
    }
    $.ajax("/accounts/signup.php", {
        data: {
            "username": $("#register-username").val(),
            "password": $("#register-password").val(),
            "email": $("#register-email").val()
        },
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            if(data == "OK") {
                //success
                //user now needs to verify email
                $("#account-result")[0].innerHTML = "Sign-up successful! We just need to verify the email address you entered belongs to you. Please visit your email and follow the link shown in the email. If you don't see the message, check your spam folder.";
            } else {
                //error
                $("#account-result")[0].innerHTML = data;
            }
        }
    });
    if(ga !== undefined) //user does not have ga disabled to some script blocker
    {
        ga("send", "pageview", "/accounts/signup.php");
    }    
    return false;
}
function performLogout() {
    console.log("Logging out...");
    $.ajax("/accounts/logout.php", {
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            if(data === "OK") {
                location.reload();
            } else {
                alert(data);
            }
        }
    })
    if(ga !== undefined) //user does not have ga disabled to some script blocker
    {
        ga("send", "pageview", "/accounts/logout.php");
    }
}
function processCollection() {
    console.log("Attempting to process collection");
    $.ajax("/savecollection.php", {
        data: {
            "collection_text": $("#collection-help #collection-textarea").val()
        },
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            if(data === "OK") {
                $("#collection-help-text")[0].innerHTML = "We're almost done! Just some finishing up. We'll automatically refresh this page once we're done.";
                trashDB(function() {
                    $("#collection-help-text")[0].innerHTML = "We're done! Now refreshing the page...";
                    location.reload();
                });
            } else {
                $("#collection-help-text")[0].innerHTML = data;
                $("#collection-submit").text("Step 3: Click here!");
            }
        }
    });
    $("#collection-submit").text("Processing...");
    $("#collection-help-text")[0].innerHTML = "This shouldn't take too long. Please don't move to another page or close this tab.";
}
function dismissPopups() {
    disableCollectionHelp();
    disableLogin();
}
function loginTab() {
    $("#login").removeClass("hide");
    $("#signup").addClass("hide");
    $(".tab-group .tab").removeClass("active");
    $(".tab-group .tab:first-child").addClass("active");
    $("#account-result")[0].innerHTML = "";
}
function registerTab() {
    $("#login").addClass("hide");
    $("#signup").removeClass("hide");
    $(".tab-group .tab").removeClass("active");
    $(".tab-group .tab:last-child").addClass("active");
    $("#account-result")[0].innerHTML = "";
}
function passwordCheck() {
    if($("#register-password").val() == "" || $("#register-password-confirm").val() == "") {
        $("#password-match")[0].innerHTML = "";
        return;
    }
    if($("#register-password").val() !== $("#register-password-confirm").val()) {
        $("#password-match")[0].innerHTML = "The two passwords do not match.";
    } else {
        $("#password-match")[0].innerHTML = "";
    }
}
$(document).ready(function() {
    $("#accounts img").on("click", function() {
        if($("#accounts")[0].getAttribute("data-loggedin") === "0") {
            if($("#login-signup").css("display") == "none") {
                enableLogin();
            } else {
                disableLogin();
            }
        } else {
            $("#accounts #account-popup").slideToggle();
        }
    });
    $("#exit-icon").on("click", function() {
        disableLogin();
        disableCollectionHelp();
    });
    $(document).on("keyup", function(e) {
        if (e.which == 27) { // escape key maps to keycode `27`
            disableLogin();
            disableCollectionHelp();
        }
    });
    $(".password-control").on("blur", passwordCheck);
});
