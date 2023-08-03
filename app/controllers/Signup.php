<?php

class Signup extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check signup requirements
            require_once dirname(__DIR__, 1) . "/models/SignupCheck.php"; 
            $signupCheck = new SignUpCheck;

            $username = $_POST["username"];
            $pass = $_POST["userpass"];
            $cpass = $_POST["cpass"];

            if (!$signupCheck->checkLength($username, $pass)) {
                $this->displayViews();
                echo "
                <script type='text/javascript'>
                Swal.fire({
                    title: 'Error!',
                    text: 'Username or Password length requirements not met',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                  })
                </script>";

                die();
            }

            if (!$signupCheck->checkPassMatch($pass, $cpass)) {
                $this->displayViews();
                echo "
                <script type='text/javascript'>
                Swal.fire({
                    title: 'Error!',
                    text: 'Passwords don't match',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                  })
                </script>";

                die();
            }

            if (!$signupCheck->checkUserAvail($username)) {
                $this->displayViews();
                echo "
                <script type='text/javascript'>
                Swal.fire({
                    title: 'Error!',
                    text: 'Username not available, please try another',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                  })
                </script>";
                die();
            }
            
            // Only if requirements are met, create user
            $this->doCreateUser();
        }

        $this->displayViews();
    }

    function doCreateUser()
    {
        require_once dirname(__DIR__, 1) . "/models/Account.php";

        // Get user input
        $username = $_POST["username"];
        $userpass = $_POST["userpass"];

        $account = new Account;

        // Create new user
        if ($account->createUser($username, $userpass)) {
            $base = new BaseController;
            echo $base->getRedirect("login", "signup-success");
        } else {
            echo "
            <script type='text/javascript'>
            Swal.fire({
                title: 'Error!',
                text: 'There was an error creating your account. Please try again later.',
                icon: 'error',
                confirmButtonText: 'Ok'
              })
            </script>";

        }
    }
    function displayViews()
    {
        $this->displayContent("signup.pug", "Signup", []);
    }
}
?>