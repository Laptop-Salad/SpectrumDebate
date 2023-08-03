const searchResults = document.getElementById("searchResults");
const search = document.getElementById("search");

// Initially hide search results box
searchResults.style.display = "none";

search.addEventListener("focus", () => {
    searchResults.style.display = "block";
});

document.getElementById("searchContainer").addEventListener("mouseenter", () => {
    searchResults.style.display = "block";
});

document.getElementById("searchContainer").addEventListener("mouseleave", () => {
    searchResults.style.display = "none";
});

// Get search results
search.addEventListener("input", () => {
    getSearchRes();
});

search.addEventListener("click", () => {
    getSearchRes();
});

function getSearchRes() {
    let currTerm = search.value;
    let xmlhttp = new XMLHttpRequest();
    
    // When xmlhttp client is ready, send request
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Clear previous search results
            document.getElementById("searchStatements").innerHTML = "";
            document.getElementById("searchUsers").innerHTML = "";

            // Show no search results first
            $("#searchStatements").append(`<p>No results found</p>`);
            $("#searchUsers").append(`<p>No results found</p>`);

            var data = JSON.parse(this.responseText);
            var statements = data.statements;
            var users = data.users;

            console.log(statements);
            console.log(users);

            for (var i = 0; i < statements.length; i++) {
                // Clear previous search results from container
                document.getElementById("searchStatements").innerHTML = "";
                    
                var currStmt = statements[i];

                $("#searchStatements").append(`
                <a href='statement/${currStmt.id}'>${currStmt.title}</a>
                <div>
                <p>${currStmt.username}</p>
                <p>•</p>
                <p>${currStmt.time}</p>
                </div>
                `)
            }

            for (var i = 0; i < users.length; i++) {
                // Clear previous search results from container
                document.getElementById("searchUsers").innerHTML = "";
    
                var currStmt = users[i];

                $("#searchUsers").append(`
                <a href='user/${currStmt.username}/statements'>${currStmt.username}</a>
                `)
            }
        }
    };

    xmlhttp.open("GET", "//localhost/search/" + currTerm, true);
    xmlhttp.send();
}