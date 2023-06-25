<?php
    class fullStatement extends BaseController {
        function __construct($id) {
            $this->baseConstruct();
            require dirname(__DIR__, 1) . "/models/statements.php";
            require $this->connectDB();
            $statement = new Statement($conn);
            $data = $statement->getStatementById($id);

            // Get votes
            require dirname(__DIR__, 1) . "/models/votes.php";
            $vote = new Vote($conn);
            $votesCount = $vote->getStatementVotesCount($data[0]);

            // Display view
            $contentVariables = [
                "statement" => $data,
                "votesCount" => $votesCount,
            ];    

            $this->displayContent("full_statement.pug", $data[2], $contentVariables);
        }
    }
?>