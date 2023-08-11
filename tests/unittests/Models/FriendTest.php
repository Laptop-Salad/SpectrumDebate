<?php
require_once dirname(__DIR__, 3) . "/app/models/Account.php";
require_once dirname(__DIR__, 3) . "/app/models/Friend.php";

use PHPUnit\Framework\TestCase;

class FriendTest extends TestCase {
    private $account;
    private $friend;
    private $friendshipId;
    private $userFromId;
    private $userToId;
    public function setUp() : void {
        // Create test accounts
        $this->account = new Account;

        $result = $this->account->createUser("UserFrom", "Password");
        $this->userFromId = $this->account->conn->insert_id;
        $this->assertTrue(
            $result
        );

        $result = $this->account->createUser("UserTo", "Password");
        $this->userToId = $this->account->conn->insert_id;
        $this->assertTrue(
            $result
        );

        // Instantiate Friend model
        $this->friend = new Friend;

        // Create test friendship
        $result = $this->friend->createFriend("UserFrom", "UserTo");
        $this->friendshipId = $this->friend->conn->insert_id;
        $this->assertTrue(
            $result
        );
    }

    public function testDeleteFriend() {
        $result = $this->friend->deleteFriendship("UserFrom", "UserTo");
        $this->assertTrue(
            $result
        );
    }

    public function testFindFriendship() {
        $result = $this->friend->findFriendship("UserFrom", "UserTo");

        $this->assertNotNull(
            $result
        );

        $this->assertEquals(
            $this->friendshipId,
            $result
        );

        $result = $this->friend->findFriendship("UserTo", "UserFrom");
        $this->assertNull(
            $result
        );
    }

    public function testGetUserFollows() {
        $result = $this->friend->getUserFollows("UserFrom");

        $this->assertNotEmpty(
            $result
        );

        $this->assertEquals(
            "UserTo",
            $result[0]["username"]
        );
    }

    public function testGetUserFollowers() {
        $result = $this->friend->getUserFollowers("UserTo");

        $this->assertNotEmpty(
            $result
        );

        $this->assertEquals(
            "UserFrom",
            $result[0]["username"]
        );
    }

    public function tearDown() : void {
        // Delete users, database deletes friendship when user is deleted
        $result = $this->account->deleteUser($this->userFromId);
        $this->assertTrue(
            $result
        );

        $result = $this->account->deleteUser($this->userToId);
        $this->assertTrue(
            $result
        );
    }
}

?>