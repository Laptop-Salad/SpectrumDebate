<?php
class DeleteComment extends BaseController {
    private $currComment;
    private $commentId;
    function __construct($commentId) {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        $this->commentId = $commentId;
        $this->currComment = $this->doFindComment();

        if ($this->checkDeleteValid()) {
            $this->doDeleteComment();
        } else {
            $this->getRedirect("statement/" . $this->currComment["statement_id"]);
        }

        echo $this->getRedirect("statement/" . $this->currComment["statement_id"]);
    }

    function doFindComment() {
        require_once dirname(__DIR__, 1) . "/models/comments.php";
        $comment = new Comment;
        $currComment = $comment->getCommentById($this->commentId);
        return $currComment;
    }

    function checkDeleteValid() {
        // Ensure user owns comment
        if ($this->currComment["username"] != $_SESSION["username"]) {
            return false;
        }

        return true;
    }

    function doDeleteComment() {
        $comment = new Comment;
        $comment->deleteComment($this->commentId);
    }
}

?>