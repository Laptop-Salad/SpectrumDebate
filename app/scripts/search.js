const searchResults = document.getElementById("searchResults");
const search = document.getElementById("search");

search.addEventListener("focus", () => {
    searchResults.style.display = "block";
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

            if (statements && statements.length > 0) {
                document.getElementById("searchStatements").innerHTML = "";
                for (var i = 0; i < statements.length; i++) {                    
                    var currStmt = statements[i];
    
                    $("#searchStatements").append(`
                    <a href='${domain}/statement/${currStmt.id}'>${currStmt.title}</a>
                    <div>
                    <p>${currStmt.username}</p>
                    <p>•</p>
                    <p>${currStmt.time}</p>
                    </div>
                    `)
                }    
            } 

            if (users && users.length > 0) {
                document.getElementById("searchUsers").innerHTML = "";
                for (var i = 0; i < users.length; i++) {    
                    var currStmt = users[i];
    
                    $("#searchUsers").append(`
                    <a href='${domain}/user/${currStmt.username}'>${currStmt.username}</a>
                    `)
                }
    
            }
        }
    };

    xmlhttp.open("GET", `${domain}/search/` + currTerm, true);
    xmlhttp.send();
}
