function processCollection() {
    console.log("Attempting to process collection");
    $.ajax("/savecollection.php", {
        data: {
            "collection_text": $("#collection #collection-textarea").val()
        },
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            if(data === "OK") {
                $("#collection-help-text")[0].innerHTML = "We're almost done! Just some finishing up.";
                trashDB(function() {
                    populateDB();
                    $("#collection-help-text")[0].innerHTML = "We're done! You should now see your collection on many locations around PoxNora!";
                });
            } else {
                $("#collection-help-text")[0].innerHTML = data;
                $("#collection-submit").text("Step 3: Click here!");
            }
        }
    });
    $("#collection-submit").text("Processing...");
    $("#collection-help-text")[0].innerHTML = "This shouldn't take too long - about a minute or so. Please don't move to another page or close this tab.";
}
function removeAllTabs() {
    $("#registered .col-md-9>div").addClass("hide");
    $("#registered .col-md-3 ul li").removeClass("active");
}
function showAccountInfo(e) {
    removeAllTabs();
    $("#account-info").removeClass("hide");
    $(e).addClass("active");
}
function showCollection(e) {
    removeAllTabs();
    $("#collection").removeClass("hide");
    $(e).addClass("active");
}
function passwordChangeCheck() {
    if($("#newpassword").val() == "" || $("#newpassword-confirm").val() == "") {
        $("#password-change-match").addClass("hide");
        return;
    }
    if($("#newpassword").val() !== $("#newpassword-confirm").val()) {
        $("#password-change-match").removeClass("hide");
    } else {
        $("#password-change-match").addClass("hide");
    }
}
function attemptChangePassword() {
    if($("#newpassword").val() !== $("#newpassword-confirm").val()) {
        $("#change-password-result")[0].innnerHML = "The two passwords you entered do not match. Please try again";
        return false;
    } else {
        $.ajax("/accounts/changepassword.php", {
            data: {
                "oldpassword": $("#oldpassword").val(),
                "newpassword": $("#newpassword").val()
            },
            type: "POST",
            success: function(data, textStatus, jqXHR) {
                if(data == "OK") {
                    $("#change-password-result")[0].innerHTML = "Your password has been successfully changed.";
                    $("#newpassword").val("");
                    $("#newpassword-confirm").val("");
                    $("#oldpassword").val("");
                } else {
                    //error
                    $("#change-password-result")[0].innerHTML = data;
                }
            }
        });
    }
    $("#change-password-result")[0].innerHTML = "Processing...";
    if(ga !== undefined) //user does not have ga disabled to some script blocker
    {
        ga("send", "pageview", "/accounts/changepassword.php");
    }
    return false;
}
function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
$(document).ready(function() {
   $("#newpassword, #newpassword-confirm").on("blur", passwordChangeCheck);
   if(getParameterByName("collection") == "") {
    showCollection($("#registered .col-md-3 ul li")[1]);
   }
});