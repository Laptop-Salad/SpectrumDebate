<?php

    class VoteController extends BaseController {
        private $statementId;
        private $opinion;
        function __construct($statementId, $opinion) {
            $this->baseConstruct();
            $this->ensureUserLoggedIn();

            $this->statementId = $statementId;
            $this->opinion = $opinion;

            if (!$this->checkVoteValid()) {
                echo $this->getRedirect("statement/$statementId");
                die();
            }

            $this->doCreateVote();
            echo $this->getRedirect("statement/$statementId");
        }
        
        function doCreateVote() {
            require_once dirname(__DIR__, 1) . "/models/votes.php";

            $vote = New Vote;
            $findVote = $vote->findVote($this->statementId, $_SESSION["username"]);

            if ($findVote) {
                // If opinions are the same, delete
                if ($findVote["opinion"] == $this->opinion) {
                    $vote->deleteVote($findVote["id"]);
                } else {
                    // If opinions are different, update
                    $vote->updateVote($findVote["id"], $this->opinion);
                }
            } else {
                // Create new vote
                $vote->createVote($_SESSION["username"], $this->statementId, $this->opinion);
            }
        }

        function checkVoteValid() {
            // Ensure post exists
            require_once dirname(__DIR__, 1) . "/models/statements.php";
            $statement = new Statement;
            
            $currStatement = $statement->getStatementById($this->statementId);

            if (!$currStatement) {
                return False;
            }

            return True;
        }
    }
?>