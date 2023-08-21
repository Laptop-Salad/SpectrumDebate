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
})

commentsBtn.addEventListener('click', () => {
  $("#followingList").hide();
  $("#followersList").hide();
  $("#statementsList").hide();
  $("#commentsList").show();

})

followingBtn.addEventListener('click', () => {
  $("#commentsList").hide();
  $("#statementsList").hide();
  $("#followersList").hide();
  $("#followingList").show();
})

followersBtn.addEventListener('click', () => {
  $("#commentsList").hide();
  $("#followingList").hide();
  $("#statementsList").hide();
  $("#followersList").show();
})

// User profile edit
$("#profileBioSave").hide();
$("#profileBioEditable").hide();

$("#profileBioEdit").click(function () {
  $("#profileBioEdit").hide();
  $("#profileBioSave").show();

  $("#profileBioEditable").show();
  $("#profileBio").hide();
  
  $("#profileBioEditable").focus();
})

$("#profileBioSave").click(function () {
  $("#profileBioSave").hide();
  $("#profileBioEditable").hide();
  $("#profileBio").show();
  $("#profileBioEdit").show();

  // Create post request
  const formData = new FormData();

  const username = $("h1").text();
  formData.append("bio", $("#profileBioEditable").val());

  const request = new XMLHttpRequest();
  request.open("POST", `${domain}/edit-user/${username}`, true);
  request.send(formData);

  request.onreadystatechange = function () {
    if (request.readyState === 4) {
      if (request.status === 200) {
        var response = request.responseText;

        if (response === "1") {
          Swal.fire({
            title: 'Success!',
            text: 'Profile updated successfully',
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload()
            }
          })
        } else {
          Swal.fire({
            title: 'Error!',
            text: 'Profile was not updated, please try again later...',
            icon: 'error',
            confirmButtonText: 'Ok'
          })
        }
      } else {
        Swal.fire({
          title: 'Error!',
          text: 'Profile was not updated, please try again later...',
          icon: 'error',
          confirmButtonText: 'Ok'
        })
      }
    }
  }
})