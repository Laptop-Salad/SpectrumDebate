<?php
    class UserProfile extends BaseController {
        private $username;
        function __construct($username) {
            $this->username = $username;
            $this->baseConstruct();

            // Get username
            require_once dirname(__DIR__, 1) . "/models/accounts.php";
            $account = new Account();
            $userId = $account->findUser($this->username);

            // If user isn't found don't continue
            if ($userId == "") {
                $this->displayContent("user_profile.pug", "404 Not Found", []);
                die();
            }

            // Get properly formatted username
            $this->username = $account->findUserById($userId);

            // Get statements
            require_once dirname(__DIR__, 1) . "/models/statements.php";
            $statement = new Statement;
            $statements = $statement->getUserStatements($this->username);

            // Get comments
            require_once dirname(__DIR__, 1) . "/models/comments.php";
            $comment = new Comment();
            $comments = $comment->getUserComments($userId);

            $variables = [
                "author" => $this->username,
                "statements" => $statements,
                "comments" => $comments
            ];

            $this->displayContent("user_profile.pug", $this->username, $variables);
        }
    }
?>