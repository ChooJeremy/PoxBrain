function enableLogin() {
    $("#login-signup").css("display", "block");
    $("#dim").css("display", "block");
}
function disableLogin() {
    $("#login-signup").css("display", "none");
    $("#dim").css("display", "none");
}
function performLogin() {
    $.ajax("/login.php", {
        data: {
            "email": $("#login-email").val(),
            "password": $("#login-password").val(),
            "remember": $("#login-remember")[0].checked ? 1 : 0
        },
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            alert(data);
        }
    });
    return false;
}
function performRegister() {
    $.ajax("/signup.php", {
        data: {
            "username": $("#register-username").val(),
            "password": $("#register-password").val(),
            "email": $("#register-email").val()
        },
        type: "POST",
        success: function(data, textStatus, jqXHR) {
            alert(data);
        }
    });
    return false;
}
$(document).ready(function() {
    $("#accounts").on("click", function() {
        if($("#login-signup").css("display") == "none") {
            enableLogin();
        } else {
            disableLogin();
        }
    });
    $("#exit-icon").on("click", function() {
        disableLogin();
    });
    $(document).on("keyup", function(e) {
         if (e.which == 27) { // escape key maps to keycode `27`
            disableLogin();
        }
    });
});