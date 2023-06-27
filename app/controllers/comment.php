<?php
class CommentController extends BaseController {
    public $statement_id;
    function __construct($statement_id) {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        $this->statement_id = $statement_id;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require dirname(__DIR__, 1) . "/models/comments.php";
            $comment = new Comment;
            $comment->createNewComment($this->statement_id, $_POST["comment"], $_SESSION["username"]);
        }

        echo $this->getRedirect("statement/$statement_id");
    }
}
?>