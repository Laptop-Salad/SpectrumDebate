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

// Toggle View statements or friends
$("#commentsList").hide();
$("#followingList").hide();
$("#followersList").hide();

const statementsBtn = document.getElementById("statementsBtn");
const commentsBtn = document.getElementById("commentsBtn");
const followingBtn = document.getElementById("followingBtn");
const followersBtn = document.getElementById("followersBtn");

statementsBtn.addEventListener('click', () => {
  $("#commentsList").hide();
  $("#followingList").hide();
  $("#followersList").hide();
  $("#statementsList").show();
});

commentsBtn.addEventListener('click', () => {
  $("#followingList").hide();
  $("#followersList").hide();
  $("#statementsList").hide();
  $("#commentsList").show();

});

followingBtn.addEventListener('click', () => {
  $("#commentsList").hide();
  $("#statementsList").hide();
  $("#followersList").hide();
  $("#followingList").show();
});

followersBtn.addEventListener('click', () => {
  $("#commentsList").hide();
  $("#followingList").hide();
  $("#statementsList").hide();
  $("#followersList").show();
})

