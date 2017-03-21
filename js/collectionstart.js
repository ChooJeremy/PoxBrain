function collectionRegister() {
    if($("#collection-register-password").val() !== $("#collection-register-password-confirm").val()) {
        $("#signup-result")[0].innerHTML = "Both passwords do not match. Please try again.";
        return false;
    }
    $.ajax("/accounts/signup.php", {
        data: {
            "username": $("#collection-register-username").val(),
            "password": $("#collection-register-password").val(),
            "email": $("#collection-register-email").val()
        },
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            if(data == "OK") {
                //success
                //user now needs to verify email
                $("#signup-result")[0].innerHTML = "OK, now we just need to verify that you own that email address. We've sent you an email from no-reply@poxbrain.jch.ooo, please check your email and click on that link. If you don't see the message, check your spam folder. <button type='button' onclick='accountFinish()' class='btn btn-primary'>Once you're done, click here</button>"
                $("#collection-register button").removeClass("btn-primary").addClass("btn-default");
                window.scrollTo(0,document.body.scrollHeight);
            } else {
                //error
                $("#signup-result")[0].innerHTML = data;
            }
        }
    });
    if(ga !== undefined) //user does not have ga disabled to some script blocker
    {
        ga("send", "pageview", "/accounts/signup.php");
    }
    return false;
}
function accountFinish() {
    $.ajax("/accounts/logincheck.php", {
        type: "GET",
        success: function(data, textStatus, jqXHR) {
            if(data === "You are not signed in") {
                $("#signup-result")[0].innerHTML = "You're not logged in. Please try logging in below: ";
                $("#login-div").css("display", "block");
                window.scrollTo(0,document.body.scrollHeight);
            } else {
                $("#collection-div").css("display", "block");
            }
        }
    });
    return false;
}
function collectionLogin() {
    $.ajax("/accounts/login.php", {
        data: {
            "email": $("#collection-login-email").val(),
            "password": $("#collection-login-password").val(),
            "remember": $("#collection-login-remember")[0].checked ? 1 : 0
        },
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            if(data == "OK") {
                $("#collection-div").css("display", "block");
                $("#collection-login button").removeClass("btn-primary").addClass("btn-default");
                window.scrollTo(0,document.body.scrollHeight);
            } else {
                //error
                $("#login-result")[0].innerHTML = data;
            }
        }
    });
    if(ga !== undefined) //user does not have ga disabled to some script blocker
    {
        ga("send", "pageview", "/accounts/login.php");
    }
    return false;
}
function collectionComplete() {
    console.log("Attempting to process collection");
    $.ajax("/savecollection.php", {
        data: {
            "collection_text": $("#collection-div #c-textarea").val()
        },
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            if(data === "OK") {
                $("#c-help-text")[0].innerHTML = "We're almost done! Just some finishing up.";
                trashDB(function() {
                    $("#c-help-text")[0].innerHTML = "We're done!";
                    $("#c-submit").text("Finish");
                    populateDB();
                    $("#loading").removeClass("hide");
                    $("#c-submit").removeClass("btn-primary").addClass("btn-default");
                });
            } else {
                $("#c-help-text")[0].innerHTML = data;
                $("#c-submit").text("Finish");
            }
        }
    });
    $("#c-submit").text("Processing...");
    $("#c-help-text")[0].innerHTML = "This shouldn't take too long - about a minute or so. Please don't move to another page or close this tab.";
}