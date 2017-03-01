var db;
function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
    .substr(1)
        .split("&")
        .forEach(function (item) {
        tmp = item.split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    });
    return result;
}

function saveItem(name, item) {
    try {
        localStorage.setItem(name, item);
    } catch (e) {
        alert('Error saving to storage.');
        throw e;
    }
}

function loadItem(name){
    try {
        return localStorage.getItem(name);
    } catch(e) {
        alert("Error loading from storage.");
        throw e;
    }
}

function handleMenu() {
    if(loadItem("accessLevel") == "full") {
        $(".sudo").removeClass("hide");
        $(".read-only").addClass("hide");
    }
    else if(loadItem("accessLevel") == "read-only") {
        $(".sudo").addClass("hide");
        $(".read-only").removeClass("hide");
    }
}

function openDB() {
    db = window.openDatabase("database", "1.0", "poxdb", 1000000);
}

function errorCB(transaction, err) {
    console.log("Error occured while executing SQL: "+err.code + ", " + err.message);
    console.log(err);
}

function successCB(msg) {
    console.log("Success!");
}

function populateDB() {
    if(!window.openDatabase) {
      dexieOpen();
      $.ajax("/getnames.php", {
        "datatype": "json",
        "success": function(data) {
            var result = JSON.parse(data);
            //before we start
            saveItem("lastKnownUpdatedID", -1); //-1 means an update is beginning. If you start the page and find that it's -1, that means that there
            //was an update failure. Please reset the database and try again.
            dexieDB.Searches.bulkAdd(result).then(function() {
                $.ajax("/getlastid.php", {
                    "datatype": "text",
                    "success": function(data) {
                        saveItem("lastKnownUpdatedID", data);
                        console.log("All done");
                        $("#loading").addClass("hide");
                    }
                });
            });
        }
      });
    } else {
        db.transaction(loadDB, errorCB, successCB);
    }
}

function dexieOpen() {
    dexieDB = new Dexie("searches");
    dexieDB.version(1).stores({
        Searches: "++_ID,ID,Name,Type,SubText,Explanation,[ID+Type]"
    });
    dexieDB.open();
}

function loadDB(tx) {
    saveItem("lastKnownUpdatedID", -1);
    
        tx.executeSql("CREATE TABLE IF NOT EXISTS `Searches` (" +
    "  `ID` int(11) NOT NULL," +
    "  `Name` text NOT NULL," +
    "  `Type` int(11) NOT NULL," +
    "  `SubText` text NOT NULL," +
    "  `Explanation` text NOT NULL," +
    "  PRIMARY KEY (`ID`, `Type`)" +
    ")");
    
    //Get data from server and dump it all into the database
    $.ajax("/getnames.php", {
        "datatype": "json",
        "success": function(data) {
            var result = JSON.parse(data);
            console.log(result);
            addDBRow(result, 0, function() {
                $.ajax("/getlastid.php", {
                    "datatype": "text",
                    "success": function(data) {
                        saveItem("lastKnownUpdatedID", data);
                        $("#loading").addClass("hide");
                    }
                });
            });
        }
    });
}

function addDBRow(result, counter, callback) {
    console.log("Running add db row for " + counter);
    //Parse the result into a long insert string, then run that
    var params = [];
    var query = "INSERT INTO Searches (ID, Name, Type, SubText, Explanation) VALUES ";
    for(var i = counter, l = counter + 18; i < result.length && i < l; i++) {
        query += "(?, ?, ?, ?, ?)";
        params.push(result[i].ID, result[i].Name, result[i].Type, result[i].SubText, result[i].Explanation);
        if(i + 1 != result.length && i + 1 < l) {
            query += ", ";
        }
        counter = i;
    }
    counter++;
    console.log(query);
    console.log(params);
    runQuery(query, params, function() {
        if(counter < result.length) {
            addDBRow(result, counter, callback)
        } else {
            callback();
        }
    });
}

function checkIfRequireUpdate(callback) {
    if(loadItem("lastKnownUpdatedID") < 0) {
        trashDB(function() {
            console.log("Trash db called, returning true");
            callback(true);
        });
        return true;
    }
    if(Date.now() - loadItem("lastKnownCheckTime") < 86400000) {// 604800000) { //time for 1 week
        callback(false);
        return false;
    }
    saveItem("lastKnownCheckTime", Date.now());
    if(loadItem("lastKnownUpdatedID") == null || loadItem("lastKnownUpdatedID") == 0) {
        callback(true);
        return true;
    } else {
        $.ajax("/getlastid.php", {
            "datatype": "text",
            "success": function(data) {
                if(parseInt(data) != loadItem("lastKnownUpdatedID")) {
                    trashDB(function() {
                        callback(true);
                    });
                    return true;
                } else {
                    callback(false);
                    return false;
                }
            }
        });
    }
}

function runQuery(query, params, callback) {
  
   db.transaction(function(tx) {
        tx.executeSql(query, params, callback, errorCB);
    }, errorCB);
}

function trashDB(callback) {
    callback = callback || successCB;
    saveItem("lastKnownCheckTime", 0);
    saveItem("lastKnownUpdatedID", 0);
    if(!window.openDatabase) {
        dexieDB.delete()
            .then(callback)
            .catch(errorCB);
    } else {
        db.transaction(function(tx) {
            tx.executeSql("DROP TABLE Searches");
        }, errorCB, callback);
    }
}

function logQuery(query) {
    runQuery(query, [], function(tx, results) {
        console.log(results.rows);
    });
}

$(document).ready(function() {
    //use web sql, but fall back to indexed db if not available
    if(!window.openDatabase) {
        dexieOpen();
    } else {
        openDB();
    }
})