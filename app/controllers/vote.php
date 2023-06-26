<?php

    class VoteController extends BaseController {
        public $conn;
        public $statement_id;
        public $opinion;
        function __construct($statement_id, $opinion) {
            $this->baseConstruct();
            $this->ensureUserLoggedIn();

            require $this->connectDB();
            $this->conn = $conn;

            $this->statement_id = $statement_id;
            $this->opinion = $opinion;

            if (!$this->checkVoteValid()) {
                die();
            }

            $this->doCreateVote();
            echo $this->getRedirect("statement/$statement_id");
        }
        
        function doCreateVote() {
            require dirname(__DIR__, 1) . "/models/votes.php";

            $vote = New Vote($this->conn);
            $findVote = $vote->findVote($this->statement_id, $_SESSION["username"]);

            if ($findVote) {
                // If opinions are the same, delete
                if ($findVote[2] == $this->opinion) {
                    $vote->deleteVote($findVote[0]);
                } else {
                    // If opinions are different, update
                    $vote->updateVote($findVote[0], $this->opinion);
                }
            } else {
                // Create new vote
                $vote->createVote($_SESSION["username"], $this->statement_id, $this->opinion);
            }
        }

        function checkVoteValid() {
            // Person cannot vote on their own post
            require dirname(__DIR__, 1) . "/models/statements.php";
            $statement = new Statement($this->conn);
            
            $currStatement = $statement->getStatementById($this->statement_id);

            if (!$currStatement) {
                // $this->displayNotif("error", "The statement you are trying to vote on may have been deleted.");
                return False;
            }

            if ($currStatement[1] == $_SESSION["username"]) {
                // $this->displayNotif("error", "You can't vote on your own statement");
                return False;
            }

            return True;
        }
    }
?>