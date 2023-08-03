<?php
require_once dirname(__DIR__, 3) . "/app/models/Account.php";

use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase {
    private $username = "testUser";
    private $userId;
    private $password = "testPass";

    public function setUp() : void {
        $user = new Account;
        $result = $user->createUser($this->username, $this->password);
        $this->userId = $user->conn->insert_id;
        
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
    }

    public function testFindUserById() {
        $user = new Account;
        $result = $user->findUserById($this->userId);

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

    public function testDeleteUser() {
        $user = new Account;
        $result = $user->deleteUser($this->userId);

        $this->assertEquals(
            true,
            $result,
            "User was not deleted successfully"
        );
    }

    public function testGetLikeUsers() {
        $user = new Account;
        $result = $user->getLikeUsers($this->username);

        $this->assertNotEmpty(
            $result,
            "Users not found successfully"
        );

        $foundUser = false;

        foreach($result as $user) {
            if ($user["username"] == $this->username) {
                $foundUser = true;
            }
        }

        $this->assertTrue(
            $foundUser,
            "User not found"
        );
    }

    public function tearDown() : void {
        $user = new Account;
        $result = $user->deleteUser($this->userId);

        $this->assertEquals(
            true,
            $result,
            "User was not deleted successfully"
        );
    }
}
?>