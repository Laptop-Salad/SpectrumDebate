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
