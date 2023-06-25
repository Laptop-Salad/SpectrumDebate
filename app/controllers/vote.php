<?php
    class VoteController extends BaseController {
        function __construct($statement_id, $opinion) {
            $this->baseConstruct();
            $this->ensureUserLoggedIn();

            $this->$statement_id = $statement_id;
            $this->$opinion = $opinion;

            require dirname(__DIR__, 1) . "/models/votes.php";
            require $this->connectDB();

            // Create a new vote
            $vote = New Vote($conn);
            $vote->createVote($_SESSION["username"], $statement_id, $opinion);
            
            echo $this->getRedirect("statement/$statement_id");
        }
    }
?>