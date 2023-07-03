
document.getElementById("menu").addEventListener('click', () => {
    let header = document.getElementById("smallerMenu");
    header.style.display = "flex";
});

document.getElementById("closeMenu").addEventListener('click', () => {
    let header = document.getElementById("smallerMenu");
    header.style.display = "none";
});


function showNotif(state, message) {
    const dialog = document.getElementById("notif");
    dialog.open = true;

    if (state == "success") {
        dialog.setAttribute("class", "notif-success");
    } else {
        dialog.setAttribute("class", "notif-error");
    }
}