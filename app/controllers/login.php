<?php
class Login extends BaseController
{
    function __construct($forwarding = null)
    {
        $this->baseConstruct();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->doCheckCredentials();
        }

        $this->displayViews();

        switch($forwarding) {
            case "signup":
                echo "
                <script type='text/javascript'>
                Swal.fire({
                    title: 'Success!',
                    text: 'Account created. You can log in now.',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                  })
                </script>";
            default:
                break;
        }
    }

    function doCheckCredentials()
    {
        require_once dirname(__DIR__, 1) . "/models/accounts.php";

        $username = $_POST["username"];
        $userpass = $_POST["userpass"];

        $account = new Account;

        if ($account->checkCredentials($username, $userpass)) {
            $_SESSION["username"] = $username;
            $base = new BaseController;
            echo $base->getRedirect("dashboard");
        } else {
            $this->displayViews();
            // Display invalid credentials message to user
            // Hide hints
            echo "<script type='text/javascript'>",
            "document.getElementById('showInvalid').style.display = 'Block';",
            "</script>";
            die();
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

         $this->displayContent("login.pug", "Login", []);
    }
}
?>