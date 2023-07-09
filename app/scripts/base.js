document.getElementById("menu").addEventListener('click', () => {
    let header = document.getElementById("smallerMenu");
    header.style.display = "flex";
});

document.getElementById("closeMenu").addEventListener('click', () => {
    let header = document.getElementById("smallerMenu");
    header.style.display = "none";
});