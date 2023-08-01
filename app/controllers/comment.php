<?php
class CommentController extends BaseController {
    private $statementId;
    function __construct($statementId) {
        // POST only
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        $this->statementId = $statementId;
    }

    function createComment() {
        /**
         * Instantiates a comment model to create a comment.
         */
        require_once dirname(__DIR__, 1) . "/models/comments.php";
        $comment = new Comment;
        $comment->createComment($this->statementId, $_POST["comment"], $_SESSION["username"]);
    }

    function handleRequest() {
        $this->createComment();
        
        // After creating comment, redirect to statement where comment is from
        echo $this->getRedirect("statement/$this->statementId");
    }
}
?>