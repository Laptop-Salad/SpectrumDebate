// New statement dialog
const nsBtn = document.getElementById("nsBtn");
const nsModal = document.getElementById("nsModal");
const nsCloseBtn = document.getElementById("nsCloseBtn");

nsBtn.addEventListener('click', () => {
    nsModal.showModal();
})

nsCloseBtn.addEventListener('click', () => {
    nsModal.close();
})

// Edit statement dialog
const editBtn = document.getElementById("editBtn");
const editModal = document.getElementById("editModal");
const editCloseBtn = document.getElementById("editCloseBtn");

editBtn.addEventListener('click', () => {
    editModal.showModal();
})

editCloseBtn.addEventListener('click', () => {
    editModal.close();
})

