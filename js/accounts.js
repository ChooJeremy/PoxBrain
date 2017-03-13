function enableLogin() {
    $("#login-signup").css("display", "block");
    $("#dim").css("display", "block");
}
function disableLogin() {
    $("#login-signup").css("display", "none");
    $("#dim").css("display", "none");
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
                //success, refresh page
                location.reload();
            } else {
                //error
                alert(data);
            }
        }
    });
    if(ga !== undefined) //user does not have ga disabled to some script blocker
    {
        ga("send", "pageview", "/login.php");
    }
    return false;
}
function performRegister() {
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
                Location.reload();
            } else {
                //error
                alert(data);
            }
        }
    });
    if(ga !== undefined) //user does not have ga disabled to some script blocker
    {
        ga("send", "pageview", "/signup.php");
    }    return false;
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
$(document).ready(function() {
    $("#accounts").on("click", function() {
        if($("#accounts")[0].getAttribute("data-loggedin") === "0") {
            if($("#login-signup").css("display") == "none") {
                enableLogin();
            } else {
                disableLogin();
            }
        } else {
            if($("#collection-help").css("display") == "none") {
                enableCollectionHelp();
            } else {
                disableCollectionHelp();
            }
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
});
