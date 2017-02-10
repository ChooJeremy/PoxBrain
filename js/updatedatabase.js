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

function errorCB(err) {
    console.log("Error occured while executing SQL: "+err.code + ", " + err.message);
    console.log(err);
}

function successCB(msg) {
    console.log("Success!");
}

function populateDB() {
    db.transaction(loadDB, errorCB, successCB);
}

function dbInsert(objects, counter, callback) {
    runQuery("INSERT INTO Searches VALUES (?, ?, ?, ?, ?)", [objects[counter].ID, objects[counter].Name, objects[counter].Type, objects[counter].SubText, objects[counter].Explanation], function(tx, results) {
        counter++;
        if(counter < objects.length) {
            dbInsert(objects, counter, callback); 
            if(counter % 10 == 0) {console.log(counter+"/" + objects.length + " complete");}
        }
        else {
            callback();
        }
    });
}

function loadDB(tx) {
        tx.executeSql("CREATE TABLE IF NOT EXISTS `Searches` (" +
    "  `ID` text NOT NULL," +
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
            dbInsert(result, 0, function() {
                $.ajax("/getlastid.php", {
                    "datatype": "text",
                    "success": function(data) {
                        saveItem("lastKnownUpdatedID", data);
                    }
                });
            });
        }
    });
}

function checkIfRequireUpdate(callback) {
    if(Date.now() - loadItem("lastKnownCheckTime") < 604800000) {
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
                    callback(true);
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

function trashDB() {
    saveItem("lastKnownCheckTime", 0);
    saveItem("lastKnownUpdatedID", 0);
    db.transaction(function(tx) {
        tx.executeSql("DROP TABLE Searches");
    }, errorCB, successCB);
}

openDB();