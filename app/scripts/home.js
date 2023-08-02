const searchResults = document.getElementById("searchResults");
const search = document.getElementById("search");

// Initially hide search results box
searchResults.style.display = "none";

search.addEventListener("focus", () => {
    searchResults.style.display = "block";
});

search.addEventListener("focusout", () => {
    searchResults.style.display = "none";
});

// Allow search results to be clicked without disappearing
searchResults.addEventListener("mouseover", () => {
    searchResults.style.display = "block";
});

// // Get search results
// search.addEventListener("input", () => {
//     let currUsername = username.value;
//     let xmlhttp = new XMLHttpRequest();
    
//     // When xmlhttp client is ready, send request
//     xmlhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             if (this.responseText) {
//                 document.getElementById("search").innerHTML = "Username available";
//                 userAvail = true;
//             } else {
//                 document.getElementById("search").innerHTML = "Username taken";
//                 userAvail = false;
//             }
//         }
//     };

//     xmlhttp.open("GET", "//localhost/search/" + currUsername, true);
//     xmlhttp.send();
// });
