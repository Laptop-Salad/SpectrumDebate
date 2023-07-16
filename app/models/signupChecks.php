<?php
require_once "baseModel.php";

class SignupCheck extends BaseModel {
    // Check if username is available
    function checkLength($username, $password) {
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

    // Check if username and password meets length requirements
    function checkUserAvail($username) {
        require_once "accounts.php";
        $account = new Account;
        $checkUser = $account->findUser($username);
        
        if ($checkUser == "") {
            return true;
        } else {
            return false;
        }
    }

    // Check is password matches cpassword
    function checkPassMatch($password, $cpassword) {
        return ($password == $cpassword);
    }
}
?>