<?php
class FriendController extends BaseController {
    private $toUser;
    function __construct($toUser) {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();
        $this->toUser = $toUser;
        $this->displayContent("base.pug", "Spectrum Debate", []);

        // Cannot befriend self
        if ($_SESSION["username"] == $toUser) {
            echo "
                <script type='text/javascript'>
                Swal.fire({
                    title: 'Notice!',
                    text: 'You can\'t add yourself as a friend.',
                    icon: 'info',
                    confirmButtonText: 'Ok'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = '$this->domain/user/$toUser';
                    }
                  })
                </script>";
              die();
        }

        require_once dirname(__DIR__, 1) . "/models/Friend.php";
        $friend = new Friend;

        // Is user already a friend
        if (!is_null($friend->findFriendship($_SESSION["username"], $toUser))) {
          if ($friend->deleteFriendship($_SESSION["username"], $toUser)) {
            echo "<script type='text/javascript'>
            Swal.fire({
                title: 'Removed Friend',
                text: '$toUser has been removed as a friend.',
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = '$this->domain/user/$toUser';
                }
              })
            </script>";
          } else {
            echo "<script type='text/javascript'>
            Swal.fire({
                title: 'Error Removing Friend',
                text: '$toUser was not removed as a friend.',
                icon: 'error',
                confirmButtonText: 'Ok'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = '$this->domain/user/$toUser';
                }
              })
            </script>";
          }
          die();
        }

        // Create friendship
        $result = $friend->createFriend($_SESSION["username"], $this->toUser);

        if (!$result) {
            echo "<script type='text/javascript'>
            Swal.fire({
                title: 'Error!',
                text: 'There was an error trying to add $toUser as a friend. Please try again later.',
                icon: 'error',
                confirmButtonText: 'Ok'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = '$this->domain/user/$toUser';
                }
              })
            </script>";
        } else {
            echo "<script type='text/javascript'>
            Swal.fire({
                title: 'New friend',
                text: '$toUser has been added as a friend.',
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = '$this->domain/user/$toUser';
                }
              })
            </script>";
        }
    }
}
?>