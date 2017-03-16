function email_confirm() {
    $.ajax("/accounts/resend_confirmation.php", {
        data: {
            "email": $("#email_confirm_input").val(),
        },
        type: "GET",
        success: function(data, textStatus, jqXHR) {
            console.log(data);
            if(data == "OK") {
                //success, tell the user
                $("#email-result")[0].innerHTML = "Email sent! Please check your inbox.";
            } else {
                //error
                $("#email-result")[0].innerHTML = data;
            }
        }
    });
    if(ga !== undefined) //user does not have ga disabled to some script blocker
    {
        ga("send", "pageview", "/accounts/resend_confirmation.php");
    }
    return false;
}