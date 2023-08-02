<?php
require dirname(__DIR__, 3) . "/app/models/Account.php";

use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase {
    private $username = "testUser";
    private $password = "testPass";

    public function testCreateUser() {
        $user = new Account;
        $result = $user->createUser($this->username, $this->password);
        
        $this->assertEquals(
            true,
            $result, 
            "User was not created successfully"
        );
    }

    public function testFindUser() {
        $user = new Account;
        $result = $user->findUser($this->username);

        $this->assertNotNull(
            $result,
            "Username could not be found"
        );

        return $result;
    }

    /**
     * @depends testFindUser
     */
    public function testFindUserById($userId) {
        $user = new Account;
        $result = $user->findUserById($userId);

        $this->assertEquals(
            $this->username,
            $result,
            "User id could not be found"
        );
    }

    public function testCredentials() {
        $user = new Account;
        $result = $user->checkCredentials($this->username, $this->password);

        $this->assertEquals(
            true,
            $result,
            "Username or password don't match records"
        );
    }

    /**
     * @depends testFindUser
     */
    public function testDeleteUser($userId) {
        $user = new Account;
        $result = $user->deleteUser($userId);

        $this->assertEquals(
            true,
            $result,
            "User was not deleted successfully"
        );
    }
}
?>