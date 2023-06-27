<?php
    class UserProfile extends BaseController {
        private $username;
        private $conn;
        function __construct($username) {
            $this->username = $username;
            $this->baseConstruct();
            require $this->connectDB();
            $this->conn = $conn;

            // ISSUE: USERNAME IS A PUBLIC VARIABLE, CAUSES ISSUES
            // IF no user defined username is root

            // Get username
            require_once dirname(__DIR__, 1) . "/models/accounts.php";
            $account = new Account();
            $userId = $account->findUser($conn, $this->username);

            // Get statements
            require_once dirname(__DIR__, 1) . "/models/statements.php";
            $statement = new Statement($this->conn);
            $statements = $statement->getUserStatements($this->username);

            // Get comments
            require_once dirname(__DIR__, 1) . "/models/comments.php";
            $comment = new Comment($this->conn);
            $comments = $comment->getUserComments($userId);

            $variables = [
                "username" => $username,
                "statements" => $statements,
                "comments" => $comments
            ];
            
            $this->displayContent("user_profile.pug", $statements[0][1], $variables);
        }
    }
?>