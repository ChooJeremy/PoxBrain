$(document).ready(function() {
    $(".ability").mouseover(function(e) {
        if(!window.openDatabase) {
            dexieDB.Searches.where("Name").equals(e.target.textContent.replace("(Default)", "").trim()).toArray(function(array) {
                handleAbility(e, array[0]);
            });
        } else {
            runQuery("SELECT * FROM Searches WHERE Name = ? AND TYPE = 7", [e.target.textContent.replace("(Default)", "").trim()], function(tx, results) {
                handleAbility(e, results.rows[0]);
            });
        }
    });
    $(".ability").mouseleave(function(e) {
        $("#ability-popup").css("display", "none");
        $(".description-popup").remove();
    });
});

function extractAllData(description) {
    //Remove any tags (like <ability value=""></ability>) in the explanation. Or <condition value=""></condition>
    //Sample:
    // <ability value=6>Mobility</ability>
    // <condition value=eviscerated>Eviscerated</condition>
    var abilityR = /(<ability value=(\d+?)>).+?(<\/ability>)/g;
    //var abilityR = new RegExp("(<ability value=(\\d+?)>).+?(</ability>)");
    var conditionR = /(<condition value=([a-z]+?)>).+?(<\/condition>)/g;
    var mechanicR = /(<mechanic value=([a-z_]+?)>).+?(<\/mechanic>)/g;
    var results = [];
    //var conditionR = new RegExp("(<condition value=([a-z]+?)>).+?(</condition>)");
    var finalDescription = description;
    do {
        var abilityResult = abilityR.exec(description);
        if(abilityResult != null) {
            //Step 1: remove from original string
            finalDescription = finalDescription.replace(abilityResult[1], "");
            finalDescription = finalDescription.replace(abilityResult[3], "");
            //Step 2: allocate the mechanic to appear by the side
            results.push({
                "ID": abilityResult[2],
                "Type": 7
            });
        }
    } while (abilityResult != null);
    
    do {
        var conditionResult = conditionR.exec(description);
        if(conditionResult != null) {
            //Step 1: remove from original string
            finalDescription = finalDescription.replace(conditionResult[1], "");
            finalDescription = finalDescription.replace(conditionResult[3], "");
            //Step 2: allocate the condition to appear by the side
            results.push({
                "ID": conditionResult[2],
                "Type": 5
            });
        }
    } while(conditionResult != null);
    
    do {
        var mechanicResult = mechanicR.exec(description);
        if(mechanicResult != null) {
            //Step 1: remove from original string
            finalDescription = finalDescription.replace(mechanicResult[1], "");
            finalDescription = finalDescription.replace(mechanicResult[3], "");
            //Step 2: allocate the condition to appear by the side
            results.push({
                "ID": mechanicResult[2],
                "Type": 6
            });
        }
    } while(mechanicResult != null);
    
    return {
        "Result": results,
        "Description": finalDescription
        };
}

function generatePrompts(promptList, helpLocation, direction) {
    if(promptList.length == 0) {
        return;
    }
    if(!window.openDatabase) {
        //dexie
    } else {
        //get them all
        var firstTime = true;
        var queryString = "";
        var params = [];
        console.log(promptList);
        for(var i = 0; i < promptList.length; i++) {
            if(!firstTime) {
                queryString = queryString + " UNION ";
            }
            queryString = queryString + "SELECT Name, Explanation FROM Searches WHERE ID = ? AND Type = " + promptList[i]["Type"];
            params.push(promptList[i]["ID"]);
            firstTime = false;
        }
        
        console.log(queryString);
        console.log(params);
        
        runQuery(queryString, params, function(tx, results) {
            
            console.log("Query ran. Result: ");
            console.log(results.rows);
            
            var resultList = [];
            var originalY = helpLocation.top;            

            //move up accordingly
            helpLocation.top = helpLocation.top - (results.rows.length/2.0 * 150);
            for(var i = 0; i < results.rows.length; i++) {
                var extractedData = extractAllData(results.rows[i].Explanation);
                var finalDescription = extractedData["Description"];
                resultList = resultList.concat(extractedData["Result"]);
                
                //make the popup appear, starting from helpLocation
                var newItem = $(document.createElement("div"));
                newItem.addClass("description-popup");
                newItem.css("top", helpLocation.top + "px");
                newItem.css("left", helpLocation.left + "px");
                var itemName = $(document.createElement("div"));
                itemName.addClass("description-header");
                itemName.text(results.rows[i].Name);
                var itemDescription = $(document.createElement("div"));
                itemDescription.text(finalDescription);
                newItem.append(itemName, itemDescription);
                console.log(newItem);
                $("body").append(newItem);
                
                helpLocation.top += newItem.height() + 20;
            }
            
            helpLocation.left = helpLocation.left + (275 * direction)
            helpLocation.top = originalY;
            
            generatePrompts(resultList, helpLocation, direction);

        });
    }
}

function handleAbility(e, ability) {
    var description = ability.Explanation;
    
    var extractedData = extractAllData(description);
    finalDescription = extractedData["Description"];
    
    var position = $(e.target).offset();
    var helpLocation = position;
    position.left = position.left + ($(e.target).width()/2);
    $("#ability-popup").text(finalDescription).css("left", position.left).css("display", "block").css("bottom", window.innerHeight - position.top + 20);
    
    var direction = 0;
    if(helpLocation.left > window.innerWidth / 2) {
        //Appear on left
        helpLocation.left = helpLocation.left - 275;
        direction = -1;
    } else {
        //Appear on right
        helpLocation.left = helpLocation.left + ($(e.target).width()) + 75;
        direction = 1;
    }
    
    generatePrompts(extractedData["Result"], helpLocation, direction)

}