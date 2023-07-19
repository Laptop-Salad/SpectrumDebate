<?php
class CommentController extends BaseController {
    private $statementId;
    function __construct($statementId) {
        // POST only
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        $this->statementId = $statementId;

        $this->doCreateComment();

        // After creating comment, redirect to statement where comment is from
        echo $this->getRedirect("statement/$statementId");
    }

    function doCreateComment() {
        /**
         * Instantiates a comment model to create a comment.
         */
        require_once dirname(__DIR__, 1) . "/models/comments.php";
        $comment = new Comment;
        $comment->createNewComment($this->statementId, $_POST["comment"], $_SESSION["username"]);
    }
}
?>