var searchItemsData = [];
function onKeyPress(e){
  if(e.keyCode == 9) { //tab
    e.preventDefault();
    
    $("#search").val($("#search-items .selected")[0].childNodes[0].nodeValue);
    updateSuggestedText(); //We can't just put this outside the if statement since it will run on every key press.
  } else if(e.keyCode == 40) {
    e.preventDefault();
    
    var searchChildren = $("#search-items").children();
    
    var index = (searchChildren.index($("#search-items .selected")) + 1) % searchChildren.length;
    $("#search-items .selected").removeClass("selected");
    $(searchChildren[index]).addClass("selected");
    updateSuggestedText();
  } else if(e.keyCode == 38) {
    e.preventDefault();
    
    var searchChildren = $("#search-items").children();
    
    var index = (searchChildren.index($("#search-items .selected")) + searchChildren.length - 1) % searchChildren.length;
    $("#search-items .selected").removeClass("selected");
    $(searchChildren[index]).addClass("selected");
    updateSuggestedText();
  }
}
function clearSearch() {
  console.log("clear search");
  $("#hard-search").val("");
  $("#search-items").css("display", "none");
}
function updateSuggestedText() {
  console.log("Updating suggested text...");
  var suggestion = $("#search-items .selected")[0].childNodes[0].nodeValue;
  var inputText = $("#search").val();
  if(suggestion.toUpperCase().substring(0, inputText.length) == inputText.toUpperCase()) {
    $("#hard-search").val(inputText + suggestion.substring(inputText.length));
  } else {
    $("#hard-search").val("");
  }
}
function getSearchResults(searchterm, callback) {
  if(!window.openDatabase) {
    str = searchterm.toLowerCase();
    var matchesAtStart = [];
    var others = [];
    dexieDB.Searches.filter(function(val) {
        return val.Name.toLowerCase().indexOf(str) > -1;
    }).each(function(item) {
        if(item.Name.substring(0, str.length).toLowerCase() == str) {
            matchesAtStart.push(item);
        } else if(matchesAtStart.length <= 5) {
            others.push(item);
        }
    }).then(function(response) {
        function cmp(a, b) {
          if (a.Name < b.Name)
            return -1;
          if (a.Name > b.Name)
            return 1;
          return 0;
        }
        matchesAtStart.sort(cmp);
        if(matchesAtStart.length < 5) { //we need at most 5 results.
          others.sort(cmp);
          others.forEach(function(v) {
              matchesAtStart.push(v);
          });
        }
        
        callback(matchesAtStart);
    });
  } else {
    runQuery("SELECT * FROM Searches WHERE Name LIKE ? ORDER BY Name LIKE ? DESC, Name ASC", ["%" + searchterm + "%", searchterm + "%"], function(tx, results) {
      callback(results.rows);
    });
  }
}
function doSearch(e) {
  console.log("Starting search...");
  var searchterm = $("#search").val();
  if(searchterm == "") {
    clearSearch();
    return;
  }
  getSearchResults(searchterm, function(rows) {
    if(searchterm !== $("#search").val()) {
      //Query to search took too long, no point anymore, user input has changed
      return;
    }
    
    if(rows.length > 0) {
      $("#search-items").empty();
      searchItemsData = [];
      
      //Find out the list of searches and display a list of possibilites on the bottom
      for(var i = 0; i < rows.length && i < 5; i++ ) {
        $("#search-items").append("<div onclick='startSearch_Selection(" + i + ")'>" + rows[i].Name + "<span class='subtext'>" +rows[i].SubText + "</span></div>");
        searchItemsData.push({"ID": rows[i].ID, "Type": rows[i].Type});
      }
      
      if(rows.length > 0) {
        $("#search-items").css("display", "block");
        $("#search-items div:first-child").addClass("selected");
      } else {
        $("#search-items").css("display", "none");
      }
      
      updateSuggestedText();
    }
    else {
      //No match
      clearSearch();
    }
    console.log("search complete");
  });
}
function performSearch(num) {
  var itemToSearch;
  if(num != undefined) {
    itemToSearch = searchItemsData[num];
  } else {
    //If this was an item in the database, and it is a match, then we send that id directly and request that item
    var suggestion = $("#hard-search").val();
    var inputText = $("#search").val();
    if(suggestion.toUpperCase() == inputText.toUpperCase() && $("#search-items div").index($("#search-items .selected")) == 0) {
      itemToSearch = searchItemsData[0];
      //Otheriwse check if the user used arrow keys to select
    } else if($("#search-items div").index($("#search-items .selected")) != 0 && $("#search-items div").index($("#search-items .selected")) != -1) {
      var itemOrderToSearch = $("#search-items div").index($("#search-items .selected"));
      itemToSearch = searchItemsData[itemOrderToSearch];
    }
  }
  if(itemToSearch !== undefined) {
    window.location.href = "/rune.php?id=" + itemToSearch.ID + "&type=" + itemToSearch.Type;
    return false;
  }
  return true;
}
function startSearch_Selection(index) {
  performSearch(index);
}
$(document).ready(function() {
  var e = document.getElementById('search');
  e.oninput = doSearch;
  e.onpropertychange = e.oninput; // for IE8
  e.onkeydown = onKeyPress;
  // e.onchange = e.oninput; // FF needs this in <select><option>...
  
  //Load up the list of names
  checkIfRequireUpdate(function(updateRequired) {
    console.log(updateRequired);
    if(updateRequired) {
      console.log("Outdated database detected. Performing update...");
      populateDB();
    } else {
      //make the thing disappear
      $("#loading").addClass("hide");
    }
  });
  clearSearch();
});