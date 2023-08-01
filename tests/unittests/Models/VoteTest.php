<?php
require dirname(__DIR__, 3) . "/app/models/votes.php";
require dirname(__DIR__, 3) . "/app/models/accounts.php";
require dirname(__DIR__, 3) . "/app/models/statements.php";

use PHPUnit\Framework\TestCase;

class VoteTest extends TestCase {
    private $vote;
    private $voteId;
    private $statementId;
    private $username = "testUser";
    private $userId;
    private $account;
    public function setUp() : void {
        $this->account = new Account;
        $result = $this->account->createUser($this->username, "testPass1");
        $this->userId = $this->account->conn->insert_id;

        $this->assertTrue(
            $result,
            "Account was not created successfully"
        );

        $statement = new Statement;
        $result = $statement->createStatement($this->username, "Hello World!", "Hello world!");
        $this->statementId = $statement->conn->insert_id;

        $this->assertTrue(
            $result,
            "Statement was not created successfully"
        );

        $this->vote = new Vote;
        $result = $this->vote->createVote($this->username, $this->statementId, "agree");
        $this->voteId = $this->vote->conn->insert_id;

        $this->assertTrue(
            $result,
            "Vote was not created successfully"
        );
    }

    public function testGetStatementVotesCount() {
        $result = $this->vote->getStatementVotesCount($this->statementId);

        $this->assertEquals(
            0,
            $result["disagree"],
            "The number of 'disagree's was not calculates correctly"
        );

        $this->assertEquals(
            0,
            $result["neutral"],
            "The number of 'neutral's was not calculates correctly"
        );

        $this->assertEquals(
            1,
            $result["agree"],
            "The number of 'agree's was not calculates correctly"
        );

        $this->assertEquals(
            1,
            $result["total"],
            "The number of total votes was not calculates correctly"
        );
    }

    public function testFindVote() {
        $result = $this->vote->findVote($this->statementId, $this->username);

        $this->assertNotEmpty(
            $result,
            "Vote was not found"
        );

        $this->assertEquals(
            $this->voteId,
            $result["id"],
            "The correct vote was not found"
        );
    }

    public function testUpdateVote() {
        $result = $this->vote->updateVote($this->voteId, "disagree");

        $this->assertTrue(
            $result,
            "Vote was not updated correctly"
        );

        $result = $this->vote->findVote($this->statementId, $this->username);

        $this->assertEquals(
            $this->voteId,
            $result["id"],
            "The correct vote was not found"
        );

        $this->assertEquals(
            "disagree",
            $result["opinion"],
            "The correct vote was not found or not updated correctly"
        );
    }

    public function testDeleteVote() {
        $result = $this->vote->deleteVote($this->voteId);

        $this->assertNotEmpty(
            $result,
            "Vote was not deleted successfully"
        );

        $result = $this->vote->findVote($this->statementId, $this->username);

        $this->assertNull(
            $result,
            "Vote was not deleted successfully"
        );
    }

    public function tearDown() : void {
        $result = $this->account->deleteUser($this->userId);

        $this->assertTrue(
            $result,
            "Account was not deleted successfully"
        );
    }
}
?>