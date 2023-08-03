<?php
require_once dirname(__DIR__, 3) . "/app/models/Comment.php";
require_once dirname(__DIR__, 3) . "/app/models/Statement.php";
require_once dirname(__DIR__, 3) . "/app/models/Account.php";


use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase {
    private $statementId;
    private $username = "testUser";
    private $userId;
    private $password = "testPass";
    private $comment = "Hello world!";
    private $updatedComment = "Hello everyone!";
    private function createTestComment() {
        $comment = new Comment;
        $result = $comment->createComment($this->statementId, $this->comment, $this->username);

        $this->assertEquals(
            true,
            $result,
            "Test comment was not successfully created"
        );

        return $comment;
    }

    public function setUp() : void {
        // Create user for testing purposes
        $user = new Account;
        $result = $user->createUser($this->username, $this->password);

        $this->assertEquals(
            true,
            $result,
            "Test user was not successfully created"
        );

        // Get userid for testing purposes
        $this->userId = $user->conn->insert_id;

        // Create statement for testing purposes
        $statement = new Statement;
        $result = $statement->createStatement($this->username, "Hello", "Hello world!");

        $this->assertEquals(
            true,
            $result,
            "Statement was not successfully created"
        );

        // Get statement id for testing purposes
        $this->statementId = $statement->conn->insert_id;
    }

    public function testCreateComment() {
        $comment = new Comment;
        $result = $comment->createComment($this->statementId, $this->comment, $this->username);

        $this->assertEquals(
            true,
            $result,
            "Comment was not created successfully"
        );
    }

    public function testGetStatementComments() {
        $comment = $this->createTestComment();

        $result = $comment->getStatementComments($this->statementId);

        $this->assertNotNull(
            $result[0]["id"],
            "Comments could not be found"
        );

        $this->assertEquals(
            $this->statementId,
            $result[0]["statement_id"],
            "The comment's statement_id does not match the statement it is from"
        );

        $this->assertEquals(
            $this->comment,
            $result[0]["text"],
            "The comment's text do not match"
        );

        $this->assertEquals(
            $this->username,
            $result[0]["username"],
            "The comment's author do not match"
        );
    }

    public function testGetUserComments() {
        $comment = $this->createTestComment();
        $result = $comment->getUserComments($this->userId);

        $this->assertNotEmpty(
            $result,
            "User comments not found"
        );

        $this->assertEquals(
            $this->comment,
            $result[0]["text"],
            "Comment's text do not match"
        );

        $this->assertEquals(
            $this->username,
            $result[0]["username"],
            "Comment's author do not match"
        );
    }

    public function testUpdateComment() {
        $comment = $this->createTestComment();
        $result = $comment->updateComment($comment->conn->insert_id, $this->updatedComment);

        $this->assertEquals(
            true,
            $result,
            "Comment was not updated successfully"
        );
    }

    public function testGetCommentById() {
        $comment = $this->createTestComment();
        $commentId = $comment->conn->insert_id;
        $result = $comment->getCommentById($commentId);

        $this->assertEquals(
            $commentId,
            $result["id"],
            "Comment was not found successfully"
        );
    }

    public function testDeleteComment() {
        $comment = $this->createTestComment();
        $result = $comment->deleteComment($comment->conn->insert_id);

        $this->assertEquals(
            true,
            $result,
            "Comment was not deleted successfully"
        );
    }

    public function tearDown() : void {
        // Delete test user (the db deletes statements when a user is deleted)
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