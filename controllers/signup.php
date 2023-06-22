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
        require $this->connectDB();
        include dirname(__DIR__, 1) . "/models/accounts.php";

        // Get user input
        $username = $_POST["username"];
        $userpass = $_POST["userpass"];

        $account = new Account;

        // Check is user already exists
        if ($account->findUser($conn, $username)) {
            echo "Username already exists";
            die();
        }

        // Create new user
        if ($account->createUser($conn, $username, $userpass)) {
            $base = new BaseController;
            echo $base->getRedirect("login");
        }
    }
    function displayViews()
    {
        $this->displayHeader("Signup");
        $this->displayNavbar();
        Phug::displayFile(dirname(__DIR__, 1) . "/views/signup.pug");
    }
}
?>