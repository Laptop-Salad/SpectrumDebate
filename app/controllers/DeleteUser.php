<?php
class DeleteUser extends BaseController {
    private $currUsername;
    function __construct($username) {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();
        $this->currUsername = $username;

        // Ensure the user trying to delete the account actually owns the account
        if ($username != $_SESSION["username"]) {
            echo $this->getRedirect();
            die();
        }

        // Ensure account actually exists
        require_once dirname(__DIR__, 1) . "/models/Account.php";
        $account = new Account;
        $userid = $account->findUser($username);

        // If user isn't found display error page
        if ($userid == "") {
            $this->displayContent("error.pug", "404 User Not Found", ["item" => "user"]);
            die();
        }

        // If user directory exists, delete it
        $dirPath = dirname(__DIR__, 2) .  "/uploads/" . $this->currUsername;
        if (file_exists($dirPath)) {
            $files = scandir($dirPath);

            // Delete files within folder
            foreach ($files as $file) {
                $filePath = $dirPath . "/" . $file;
                if(is_file($filePath)) {
                    unlink($filePath);
                }
            }

            // Delete folder
            if(!rmdir($dirPath)) {
                $this->displayContent("navbar.pug", "Spectrum Debate", []);
                echo "
                <script type='text/javascript'>
                Swal.fire({
                    title: 'Error!',
                    text: There was an error deleting your account , please try again later',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href='$this->domain/dashboard'
                    }
                  })
                </script>";
                die();
            }
        }

        // Delete user
        $account->deleteUser($userid);
        
        // Destroy session
        require_once "Logout.php";
        $logout = new Logout(True);
    }
}
?>