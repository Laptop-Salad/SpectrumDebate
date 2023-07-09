// Username hints if username is invalid
let username = document.getElementById("username");
let usernameHint = document.getElementById("usernameHint");

username.addEventListener("input", function () {
    if (!username.checkValidity()) {
        usernameHint.style.display = "block";
    } else {
        usernameHint.style.display = "none";
    }
});

// Password hints if password is invalid
let password = document.getElementById("password");
let passwordHint = document.getElementById("passwordHint");

password.addEventListener("input", function () {
    if (!password.checkValidity()) {
        passwordHint.style.display = "block";
    } else {
        passwordHint.style.display = "none";
    }
});