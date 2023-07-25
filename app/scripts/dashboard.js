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

// Confirm delete account
const delBtn = document.getElementById("delAcc");

delBtn.addEventListener('click', () => {
    console.log("hhhh");
    Swal.fire({
        title: 'Delete account? You can\'t undo this action!',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = delBtn.getAttribute("href");
        }
      })
      
})