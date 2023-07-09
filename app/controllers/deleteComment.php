<?php
class DeleteComment extends BaseController {
    function __construct($commentId) {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        // Find comment
        require_once dirname(__DIR__, 1) . "/models/comments.php";
        $comment = new Comment;
        $currComment = $comment->getCommentById($commentId);

        // If comment doesn't exist
        if (count($currComment) == 0) {
            $this->displayContent("error.pug", "404 Comment Not Found", ["item" => "Comment"]);
            die();
        }

        // Ensure user owns comment
        if ($currComment[2] != $_SESSION["username"]) {
            echo $this->getRedirect();
            die();
        }

        // Delete comment
        $comment->deleteComment($commentId);
        echo $this->getRedirect("");
    }
}

?>