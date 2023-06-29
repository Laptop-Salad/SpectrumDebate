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
        require dirname(__DIR__, 1) . "/models/accounts.php";
        $account = new Account;
        $userid = $account->findUser($username);

        // If user isn't found display error page
        if ($userid == "") {
            $this->displayContent("error.pug", "404 User Not Found", ["item" => "user"]);
        }

        // Delete user
        $account->deleteUser($userid);
        
        // Destroy session
        require "logout.php";
        $logout = new Logout(True);
        
    }
}
?>