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
            header("Location:" . "dashboard");
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
        $headerVariables = [
            "title" => "Login",
            "containerClass" => "",
        ];

        Phug::displayFile(dirname(__DIR__, 1) . "/views/components/header.pug", $headerVariables);
        Phug::displayFile(dirname(__DIR__, 1) . "/views/components/navbar.pug");
        Phug::displayFile(dirname(__DIR__, 1) . "/views/login.pug");
    }
}
?>