$(document).ready(function() {
    $(".ability").mouseover(function(e) {
        runQuery("SELECT * FROM Searches WHERE Name = ?", [e.target.textContent.replace("(Default)", "")], function(tx, results) {
            var description = results.rows[0].Explanation;
            console.log(description);
        });
    });
});