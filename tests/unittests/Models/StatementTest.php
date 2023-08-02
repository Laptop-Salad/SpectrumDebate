<?php
require dirname(__DIR__, 3) . "/app/models/Statement.php";
require dirname(__DIR__, 3) . "/app/models/Account.php";


use PHPUnit\Framework\TestCase;

class StatementTest extends TestCase {
    private $statement;
    private $statementId;
    private $account;
    private $userId;
    public function setUp() : void {
        $this->account = new Account;
        $result = $this->account->createUser("testuser", "testpass1");
        $this->userId = $this->account->conn->insert_id;

        $this->assertEquals(
            true,
            $result,
            "User was not created successfully"
        );

        $this->statement = new Statement;
        $result = $this->statement->createStatement("testuser", "Hello world", "Hello world!");
        $this->statementId = $this->statement->conn->insert_id;

        $this->assertEquals(
            true,
            $result,
            "Statement was not created successfully"
        );
    }

    public function testUpdateStatement() {   
        $result = $this->statement->updateStatement($this->statementId, "Hello All", "Hello world");

        $this->assertEquals(
            true,
            $result,
            "Statement was not updated successfully"
        );

        $result = $this->statement->getStatementById($this->statementId);

        $this->assertEquals(
            "Hello All",
            $result["title"],
            "Statement was not updated successfully"
        );

        $this->assertEquals(
            "Hello world",
            $result["text"],
            "Statement was not updated successfully"
        );
    }

    public function testDeleteStatement() {
        $result = $this->statement->deleteStatement($this->statementId);

        $this->assertEquals(
            true,
            $result,
            "Statement was not deleted successfully"
        );

        $result = $this->statement->getStatementById($this->statementId);

        $this->assertEmpty(
            $result,
            "Statement was not deleted successfully"
        );
    }

    public function testGetAllStatements() {
        $result = $this->statement->getAllStatements();

        $this->assertNotEmpty(
            $result,
            "Statements not found successfully"
        );

        $this->assertEquals(
            $this->statementId,
            $result[0]["id"],
            "Statements not found successfully"
        );
    }

    public function testGetUserStatements() {
        $result = $this->statement->getUserStatements("testUser");

        $this->assertNotEmpty(
            $result,
            "Statements not found successfully"
        );

        $this->assertEquals(
            $this->statementId,
            $result[0]["id"],
            "Statements not found successfully"
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