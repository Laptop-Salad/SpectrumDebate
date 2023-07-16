// ** Requirements **
// Submit button is initially disabled
document.getElementById("submit").disabled = true;

let userLength = false;
let userAvail = false; 
let passLength = false;
let passMatching = false;

// ** Username Requirements **
const username = document.getElementById("username");
const userHint = document.getElementById("userLength");

// If username input is valid, length requirements are hidden
username.addEventListener("input", () => {
    if (username.checkValidity()) {
        userHint.innerHTML = "Between 3 and 10 characters ✓"
        userLength = true;
    } else {
        userHint.innerHTML = "Between 3 and 10 characters ✗";
        userLength = false;
    }

    // Ensure username available (ajax)
    if (username.value.length >= 3 && username.value.length <= 10) {
        let currUsername = username.value;
        let xmlhttp = new XMLHttpRequest();
        
        // When xmlhttp client is ready, send request
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText) {
                    document.getElementById("userAvail").innerHTML = "Username available";
                    userAvail = true;
                } else {
                    document.getElementById("userAvail").innerHTML = "Username taken";
                    userAvail = false;
                }
            }
        };

        xmlhttp.open("GET", "//localhost/user-avail/" + currUsername, true);
        xmlhttp.send();
    } else {
        document.getElementById("userAvail").innerHTML = "";
        userAvail = false;
    }
})


// ** Password Requirements **
const password = document.getElementById("password");
const passHint = document.getElementById("passLength");

// If password reaches length requirements, hide hint
password.addEventListener("input", () => {
    if (password.checkValidity()) {
        passHint.innerHTML = "Between 8 and 20 characters ✓";
        passLength = true;
    } else {
        passHint.innerHTML = "Between 8 and 20 characters ✗";
        passLength = false;
    }

    // Confirm password matches
    checkPassMatch();
})

// ** Confirm Password Matches **
const confPass = document.getElementById("cPassword");
const passMatch = document.getElementById("passMatch");

confPass.addEventListener("input", checkPassMatch);

function checkPassMatch() {
    if (confPass.value == password.value) {
        passMatch.innerHTML = "Passwords Match";
        passMatching = true;
    } else {
        passMatch.innerHTML = "Passwords don't match";
        passMatching = false;
    }
}

// ** Submit button is disabled until all requirements are met **
setInterval(function () {
    if (userAvail && userLength && passLength && passMatching) {
        document.getElementById("submit").disabled = false;
    }
}, 1000);
