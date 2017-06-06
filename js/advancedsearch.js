function createMultiSelectors(abilityList, raceList, classList) {
	//Remove multiple ranks of the same ability in abilityList, and then merge them all together as one
	for (var i = abilityList.length - 1; i >= 0; i--) {
		var match = /^(.*) \d$/.test(abilityList[i]);
		if(match) {
			var newString = abilityList[i].substring(0, abilityList[i].length - 2);
			if(abilityList[i - 1].substring(0, abilityList[i - 1].length - 2) === newString) {
				abilityList.splice(i, 1);
			} else {
				abilityList[i] = newString;
			}
		}
	};

	var abilitySelector = document.createElement("select");
	abilitySelector.multiple = "multiple";
	abilitySelector.id = "search-ability";
	for (var i = 0; i < abilityList.length; i++) {
		var newChild = document.createElement("option");
		newChild.value = abilityList[i];
		newChild.innerHTML = abilityList[i];
		abilitySelector.appendChild(newChild);
	};
	$("#search-ability").replaceWith(abilitySelector);

	var raceSelector = document.createElement("select");
	raceSelector.multiple = "multiple";
	raceSelector.id = "search-race";
	for (var i = 0; i < raceList.length; i++) {
		var newChild = document.createElement("option");
		newChild.value = raceList[i];
		newChild.innerHTML = raceList[i];
		raceSelector.appendChild(newChild);
	};
	$("#search-race").replaceWith(raceSelector);

	var classSelector = document.createElement("select");
	classSelector.multiple = "multiple";
	classSelector.id = "search-class";
	for (var i = 0; i < classList.length; i++) {
		var newChild = document.createElement("option");
		newChild.value = classList[i];
		newChild.innerHTML = classList[i];
		classSelector.appendChild(newChild);
	};
	$("#search-class").replaceWith(classSelector);

	$("#search-ability, #search-race, #search-class").multiselect({
		maxHeight: 250,
		enableFiltering: true,
		filterBehavior: 'value',
		enableCaseInsensitiveFiltering: true
	});
}
$(document).ready(function() {
	//Build ability, class and race list
	var abilityList, raceList, classList;
	if(!window.openDatabase) {
		var abilityPromise = dexieDB.Searches.where("Type").equals(7).sortBy("Name", function(arr) {
			abilityList = arr.map(a => a.Name);
		});
		var racePromise = dexieDB.Searches.where("Type").equals(9).sortBy("Name", function(arr) {
			raceList = arr.map(a => a.Name);
		});
		var classPromise = dexieDB.Searches.where("Type").equals(8).sortBy("Name", function(arr) {
			classList = arr.map(a => a.Name);
		});
		Promise.all([abilityPromise, racePromise, classPromise]).then(function() {
			createMultiSelectors(abilityList, raceList, classList);
		});
	}
	else {
		runQuery("SELECT Type, GROUP_CONCAT(Name, ',') AS Name FROM (SELECT Type, Name FROM Searches WHERE Type IN (7, 8, 9) ORDER BY Name) GROUP BY Type", [], function(tx, results) {
			abilityList = results.rows[0].Name.split(',');
			classList = results.rows[1].Name.split(',');
			raceList = results.rows[2].Name.split(',');
			createMultiSelectors(abilityList, raceList, classList);
		});
	}
});
function doAdvancedSearch() {
	//Build a search term based on what the user has, and then do a POST to /search.php
	var searchTerm = $("#search-general").val();
	if($("#search-ability-general").val() != "") {
		searchTerm += " in-ability:\"" + $("#search-ability-general").val() + "\"";
	}
	var abilitySearches = $("#search-ability").val();
	if(abilitySearches != null && abilitySearches != []) {
		for(var i = 0; i < abilitySearches.length; i++) {
			searchTerm += " ability:\"" + abilitySearches[i] + "\"";
		}
	}
	var raceSearches = $("#search-race").val();
	if(raceSearches != null && raceSearches != []) {
		for(var i = 0; i < raceSearches.length; i++) {
			searchTerm += " race:\"" + raceSearches[i] + "\"";
		}
	}
	var classSearches = $("#search-class").val();
	if(classSearches != null && classSearches != []) {
		for(var i = 0; i < classSearches.length; i++) {
			searchTerm += " class:\"" + classSearches[i] + "\"";
		}
	}

	window.location.href="/search?search=" + searchTerm;
}