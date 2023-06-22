<?php
class Login extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->doCheckCredentials();
        }

        $this->displayViews();
    }

    function doCheckCredentials()
    {
        require $this->connectDB();
        include dirname(__DIR__, 1) . "/models/accounts.php";

        $username = $_POST["username"];
        $userpass = $_POST["userpass"];

        $account = new Account;

        if ($account->checkCredentials($conn, $username, $userpass)) {
            $_SESSION["username"] = $username;
            $base = new BaseController;
            echo $base->getRedirect("dashboard");
        } else {
            echo "User not found";
        }
    }

    function displayViews()
    {
        /**
         * displays a view
         * 
         * - header
         * - default navbar
         * - content
         */

        $this->displayHeader("Login");
        $this->displayNavbar();
        Phug::displayFile(dirname(__DIR__, 1) . "/views/login.pug");
    }
}
?>