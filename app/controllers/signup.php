<?php

class Signup extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->doCreateUser();
        }

        $this->displayViews();
    }

    function doCreateUser()
    {
        require_once dirname(__DIR__, 1) . "/models/accounts.php";

        // Get user input
        $username = $_POST["username"];
        $userpass = $_POST["userpass"];

        $account = new Account;

        // Check is user already exists
        if ($account->findUser($username)) {
            $this->displayViews();
            // Show user message that username is already taken
            echo "<script type='text/javascript'>",
            "document.getElementById('showTaken').style.display = 'Block';",
            "</script>";
            die();
        }

        // Create new user
        if ($account->createUser($username, $userpass)) {
            $base = new BaseController;
            echo $base->getRedirect("login");
        }
    }
    function displayViews()
    {
        $this->displayContent("signup.pug", "Signup", [], "signup.css");
    }
}
?>