<?php
    class fullStatement extends BaseController {
        function __construct($id) {
            $this->baseConstruct();
            require dirname(__DIR__, 1) . "/models/statements.php";
            $statement = new Statement;
            $data = $statement->getStatementById($id);

            // Get votes
            require dirname(__DIR__, 1) . "/models/votes.php";
            $vote = new Vote;
            $votesCount = $vote->getStatementVotesCount($data["id"]);

            // Get comments
            require dirname(__DIR__, 1) . "/models/comments.php";
            $comment = new Comment;
            $comments = $comment->getStatementComments($id);

            // Display view
            $contentVariables = [
                "statement" => $data,
                "votesCount" => $votesCount,
                "comments" => $comments,
            ];    

            $this->displayContent("full_statement.pug", $data["title"], $contentVariables);
        }
    }
?>