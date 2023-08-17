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

        // Existing username as username
        $result = $user->findUser($this->username);

        $this->assertNotNull(
            $result,
            "Username could not be found"
        );

        // Non-existing username as username
        $result = $user->findUser("FancyUsername");

        $this->assertNull(
            $result,
            "Username is not null"
        );

        // Empty string as username
        $result = $user->findUser("");

        $this->assertNull(
            $result,
            "Username is not null"
        );

        // Null as username
        $result = $user->findUser(null);

        $this->assertNull(
            $result,
            "Username is not null"
        );

        // Integer as username
        $result = $user->findUser(5);

        $this->assertNull(
            $result,
            "Username is not null"
        );
    }

    public function testFindUserById() {
        $user = new Account;

        // Existing User id as User id
        $result = $user->findUserById($this->userId);

        $this->assertEquals(
            $this->username,
            $result,
            "User id is null"
        );

        // Non-existing User id as User id
        $result = $user->findUserById("09");

        $this->assertNull(
            $result,
            "User id is not null"
        );  

        // Empty string User id as User id
        $result = $user->findUserById("");

        $this->assertNull(
            $result,
            "User id is not null"
        );  

        // Null User id as User id
        $result = $user->findUserById(null);

        $this->assertNull(
            $result,
            "User id is not null"
        );  

        // Integer id as User id
        $result = $user->findUserById(59085);

        $this->assertNull(
            $result,
            "User id is not null"
        );  
    }

    public function testCredentials() {
        $user = new Account;

        // Existing username and password
        $result = $user->checkCredentials($this->username, $this->password);

        $this->assertEquals(
            true,
            $result,
            "Username or password doesn't match records"
        );

        // Username with an existing password
        $result = $user->checkCredentials("username", $this->password);

        $this->assertFalse(
            $result,
            "Username or password matches records"
        );

        // Non-existing username and password
        $result = $user->checkCredentials("username", "password");

        $this->assertFalse(
            $result,
            "Username or password matches records"
        );

        // Empty strings as username and password
        $result = $user->checkCredentials("", "");

        $this->assertFalse(
            $result,
            "Username or password matches records"
        );

        // Null as username and password
        $result = $user->checkCredentials(null, null);

        $this->assertFalse(
            $result,
            "Username or password matches records"
        );

        // Integer as username and password
        $result = $user->checkCredentials(5, 6);

        $this->assertFalse(
            $result,
            "Username or password matches records"
        );
    }

    public function testDeleteUser() {
        $user = new Account;

        // Existing user
        $result = $user->createUser($this->username, $this->password);
        $userId = $user->conn->insert_id;

        $result = $user->deleteUser($userId);

        $this->assertTrue(
            $result,
            "User was not deleted successfully"
        );

        // Non-existing user
        $result = $user->deleteUser("9088765");

        $this->assertFalse(
            $result,
            "User was deleted successfully"
        );

        // Empty string user
        $result = $user->deleteUser("");

        $this->assertFalse(
            $result,
            "User was deleted successfully"
        );

        // Null user
        $result = $user->deleteUser(null);

        $this->assertFalse(
            $result,
            "User was deleted successfully"
        );

        // Integer user
        $result = $user->deleteUser(9888877);

        $this->assertFalse(
            $result,
            "User was deleted successfully"
        );
    }

    public function testGetLikeUsers() {
        $user = new Account;

        // Find existing user
        $result = $user->getLikeUsers($this->username);

        $this->assertNotEmpty(
            $result,
            "Users not found successfully"
        );

        $foundUser = false;
        foreach($result as $username) {
            if ($username["username"] == $this->username) {
                $foundUser = true;
            }
        }

        $this->assertTrue(
            $foundUser,
            "User not found"
        );

        // Find non-existing user
        $result = $user->getLikeUsers("username");

        $this->assertEmpty(
            $result,
            "User found"
        );

        // Find null user
        $result = $user->getLikeUsers(null);

        $this->assertEmpty(
            $result,
            "User found"
        );

        // Find integer user
        $result = $user->getLikeUsers(98765);

        $this->assertEmpty(
            $result,
            "User found"
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