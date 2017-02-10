$(document).ready(function() {
    $(".ability").mouseover(function(e) {
        runQuery("SELECT * FROM Searches WHERE Name = ?", [e.target.textContent.replace("(Default)", "").trim()], function(tx, results) {
            var description = results.rows[0].Explanation;
            //Remove any tags (like <ability value=""></ability>) in the explanation. Or <condition value=""></condition>
            //Sample:
            // <ability value=6>Mobility</ability>
            // <condition value=eviscerated>Eviscerated</condition>
            var abilityResult = description.match(/(<ability value=(\d+?)>).+?(<\/ability>)/g);
            var conditionResult = description.match(/(<condition value=([a-z]+?)>).+?(<\/condition>)/g);
            console.log(abilityResult);
            console.log(conditionResult);
            
            var position = $(e.target).offset();
            position.left = position.left + ($(e.target).width()/2);
            $("#ability-popup").text(description).css("left", position.left).css("display", "block").css("bottom", window.innerHeight - position.top + 20);
        });
    });
    $(".ability").mouseleave(function(e) {
        $("#ability-popup").css("display", "none");
    });
});