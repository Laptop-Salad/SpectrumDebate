<?php
    class UserProfile extends BaseController {
        private $username;
        function __construct($username) {
            $this->username = $username;
            $this->baseConstruct();

            // ISSUE: USERNAME IS A PUBLIC VARIABLE, CAUSES ISSUES
            // IF no user defined username is root

            // Get username
            require_once dirname(__DIR__, 1) . "/models/accounts.php";
            $account = new Account();
            $userId = $account->findUser($this->username);

            // Get statements
            require_once dirname(__DIR__, 1) . "/models/statements.php";
            $statement = new Statement;
            $statements = $statement->getUserStatements($this->username);

            // Get comments
            require_once dirname(__DIR__, 1) . "/models/comments.php";
            $comment = new Comment();
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