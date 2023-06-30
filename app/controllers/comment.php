<?php
class CommentController extends BaseController {
    public $statementId;
    function __construct($statementId) {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        $this->statementId = $statementId;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require dirname(__DIR__, 1) . "/models/comments.php";
            $comment = new Comment;
            $comment->createNewComment($this->statementId, $_POST["comment"], $_SESSION["username"]);
        }

        echo $this->getRedirect("statement/$statementId");
    }
}
?>