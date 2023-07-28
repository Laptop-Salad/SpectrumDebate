<?php
class EditComment extends BaseController {
    private $commentId;
    function __construct($commentId) {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        $this->commentId = $commentId;

        $text = $this->ensureValid();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once dirname(__DIR__, 1) . "/models/comments.php";
            $comment = new Comment;
            $comment->updateComment($commentId, $_POST["comment"]);
            echo $this->getRedirect();
        } else {
            // Display page to edit comment
            $variables = [
                "commentId" => $commentId,
                "text" => $text,
            ];

            $this->displayContent("edit_comment.pug", "Editing Comment", $variables);
        }
    }

    function ensureValid() {
        // Get comment
        require_once dirname(__DIR__, 1) . "/models/comments.php";
        $comment = new Comment;
        $currComment = $comment->getCommentById($this->commentId);

        // If comment is not found
        if (count($currComment) == 0) {
            $this->displayContent("error.pug", "404 Comment Not Found", ["item" => "Comment"]);
            die();
        }

        // If logged in user doesn't own comment
        if ($currComment["username"] != $_SESSION["username"]) {
            echo $this->getRedirect();
            die();
        }

        return $currComment["text"];
    }
}
?>