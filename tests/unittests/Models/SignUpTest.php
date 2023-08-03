<?php
require_once dirname(__DIR__, 3) . "/app/models/SignUpCheck.php";

use PHPUnit\Framework\TestCase;

class SignUpTest extends TestCase {
    public function testCheckLength() {
        $signUpCheck = new SignupCheck;
        $result = $signUpCheck->checkLength("Hello", "Password800");

        $this->assertEquals(
            true,
            $result,
            "Username or password doesn't meet length requirements"
        );

        $signUpCheck = new SignupCheck;
        $result = $signUpCheck->checkLength("Hello", "Pass");

        $this->assertEquals(
            false,
            $result,
            "Username and password meets length requirements"
        );
    }

    public function checkUserAvail() {
        $signUpCheck = new SignupCheck;
        $result = $signUpCheck->checkUserAvail("Hello");

        $this->assertEquals(
            true,
            $result,
            "Username is not available"
        );

        $signUpCheck = new SignupCheck;
        $result = $signUpCheck->checkUserAvail("MrElephant");

        $this->assertEquals(
            false,
            $result,
            "Username is available"
        ); 
    }

    public function checkPassMatch() {
        $signUpCheck = new SignupCheck;
        $result = $signUpCheck->checkPassMatch("Password1", "Password1");

        $this->assertEquals(
            true,
            $result,
            "Passwords do not match"
        );

        $signUpCheck = new SignupCheck;
        $result = $signUpCheck->checkPassMatch("Password1", "Password2");

        $this->assertEquals(
            false,
            $result,
            "Passwords do not match"
        ); 

    }
}
?>