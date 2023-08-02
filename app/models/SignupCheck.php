<?php
require_once "BaseModel.php";

class SignupCheck extends BaseModel {
    function checkLength($username, $password) {
        /**
         * @param string $username between 3 and 10 characters
         * @param string $password between 8 and 20 characters
         * 
         * Check if username and password meets length requirements
         */
        $validUser = false;
        $validPass = false;

        if (strlen($username) >= 3 and strlen($username) <= 10) {
            $validUser = true;
        }

        if (strlen($password) >= 8 and strlen($password) <= 20) {
            $validPass = true;
        }

        return ($validPass and $validUser);
    }

    function checkUserAvail($username) {
        /**
         * @param string $username
         * 
         * Check if username is available
         */
        require_once "Account.php";
        $account = new Account;
        $checkUser = $account->findUser($username);
        
        if ($checkUser == "") {
            return true;
        } else {
            return false;
        }
    }

    function checkPassMatch($password, $cpassword) {
        /**
         * @param string $password
         * @param string $cpassword
         * 
         * Check is password matches confirm password
         */
        return ($password == $cpassword);
    }
}
?>