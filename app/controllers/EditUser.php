<?php
class EditUser extends BaseController {
    function __construct($username) {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        if ($username != $_SESSION["username"]) {
            echo "0";
            die();
        }

        require dirname(__DIR__, 1) . "/models/Account.php";
        $account = new Account;

        if ($account->updateUserVars($username, $_POST["bio"])) {
            echo "1";
        } else {
            echo "0";
        }
    }
}
?>