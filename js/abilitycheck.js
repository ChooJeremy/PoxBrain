$(document).ready(function() {
    $(".ability").mouseover(function(e) {
        runQuery("SELECT * FROM Searches WHERE Name = ?", [e.target.textContent.replace("(Default)", "").trim()], function(tx, results) {
            var description = results.rows[0].Explanation;
            var position = $(e.target).offset();
            position.left = position.left + ($(e.target).width()/2);
            $("#ability-popup").text(description).css("left", position.left).css("display", "block").css("bottom", window.innerHeight - position.top + 20);
        });
    });
    $(".ability").mouseleave(function(e) {
        $("#ability-popup").css("display", "none");
    });
});