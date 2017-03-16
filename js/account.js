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
    $("#collection-help-text")[0].innerHTML = "This shouldn't take too long. Please don't move to another page or close this tab.";
}
function removeAllTabs() {
    $("#registered .col-md-9 div").addClass("hide");
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