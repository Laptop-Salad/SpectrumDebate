function showNotif(state, message) {
    const dialog = document.getElementById("notif");
    dialog.open = true;

    if (state == "success") {
        dialog.setAttribute("class", "notif-success");
    } else {
        dialog.setAttribute("class", "notif-error");
    }
}