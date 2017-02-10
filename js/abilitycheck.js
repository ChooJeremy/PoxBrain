$(document).ready(function() {
    $(".ability").mouseover(function(e) {
        runQuery("SELECT * FROM Searches WHERE Name = ?", [e.target.textContent.replace("(Default)", "").trim()], function(tx, results) {
            var description = results.rows[0].Explanation;
            //Remove any tags (like <ability value=""></ability>) in the explanation. Or <condition value=""></condition>
            //Sample:
            // <ability value=6>Mobility</ability>
            // <condition value=eviscerated>Eviscerated</condition>
            var abilityR = /(<ability value=(\d+?)>).+?(<\/ability>)/g;
            //var abilityR = new RegExp("(<ability value=(\\d+?)>).+?(</ability>)");
            var conditionR = /(<condition value=([a-z]+?)>).+?(<\/condition>)/g;
            var mechanicR = /(<mechanic value=([a-z_]+?)>).+?(<\/mechanic>)/g;
            var extraMechanics = [], extraConditions = [], extraAbility = [];
            var extraToDisplay = [];
            //var conditionR = new RegExp("(<condition value=([a-z]+?)>).+?(</condition>)");
            var finalDescription = description;
            do {
                var abilityResult = abilityR.exec(description);
                if(abilityResult != null) {
                    //Step 1: remove from original string
                    finalDescription = finalDescription.replace(abilityResult[1], "");
                    finalDescription = finalDescription.replace(abilityResult[3], "");
                    //Step 2: allocate the mechanic to appear by the side
                    extraAbility.push(abilityResult[2]);
                }
            } while (abilityResult != null);
            
            do {
                var conditionResult = conditionR.exec(description);
                if(conditionResult != null) {
                    //Step 1: remove from original string
                    finalDescription = finalDescription.replace(conditionResult[1], "");
                    finalDescription = finalDescription.replace(conditionResult[3], "");
                    //Step 2: allocate the condition to appear by the side
                    extraConditions.push(conditionResult[2]);
                }
            } while(conditionResult != null);
            
            do {
                var mechanicResult = mechanicR.exec(description);
                if(mechanicResult != null) {
                    //Step 1: remove from original string
                    finalDescription = finalDescription.replace(mechanicResult[1], "");
                    finalDescription = finalDescription.replace(mechanicResult[3], "");
                    //Step 2: allocate the condition to appear by the side
                    extraMechanics.push(mechanicResult[2]);
                }
            } while(mechanicResult != null);
            
            //get them all
            var firstTime = true;
            var queryString = "";
            for(var i = 0; i < extraAbility.length; i++) {
                if(!firstTime) {
                    queryString = queryString = " UNION ";
                }
                queryString = queryString + "SELECT Explanation FROM Searches WHERE ID = " + extraAbility[i] + " AND ID = 7";
                firstTime = false;
            }
            for(var i = 0; i < extraConditions.length; i++) {
                if(!firstTime) {
                    queryString = queryString = " UNION ";
                }
                queryString = queryString + "SELECT Explanation FROM Searches WHERE ID = " + extraConditions[i] + " AND ID = 5";
                firstTime = false;
            }
            for(var i = 0; i < extraMechanics.length; i++) {
                if(!firstTime) {
                    queryString = queryString = " UNION ";
                }
                queryString = queryString + "SELECT Explanation FROM Searches WHERE ID = " + extraMechanics[i] + " AND ID = 6";
                firstTime = false;
            }
            console.log(queryString);
            
            var position = $(e.target).offset();
            var helpLocation = position; 
            position.left = position.left + ($(e.target).width()/2);
            $("#ability-popup").text(finalDescription).css("left", position.left).css("display", "block").css("bottom", window.innerHeight - position.top + 20);
            
            runQuery(queryString, [], function(tx, results) {
                if(helpLocation.left > window.innerWidth/2) {
                    //Appear on left
                    helpLocation.left = helpLocation.left - 150;
                } else {
                    //Appear on right
                    helpLocation.left = helpLocation.left + ($(e.target).width()) + 150;
                }
                for(var i = 0; i < results.rows.length; i++) {
                    //make the popup appear, starting from helpLocation
                }
            });
        });
    });
    $(".ability").mouseleave(function(e) {
        $("#ability-popup").css("display", "none");
    });
});