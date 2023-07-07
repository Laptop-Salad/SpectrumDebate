<?php
    class UserProfile extends BaseController {
        private $username;
        private $userId;
        function __construct($username, $view) {
            $this->username = $username;
            $this->baseConstruct();

            // Get username
            require_once dirname(__DIR__, 1) . "/models/accounts.php";
            $account = new Account();
            $userId = $account->findUser($this->username);
            $this->userId = $userId;

            // If user isn't found don't continue
            if ($this->userId == "") {
                $this->displayContent("user_profile.pug", "404 Not Found", []);
                die();
            }

            // Get properly formatted username
            $this->username = $account->findUserById($this->userId);

            // Display content depending on view
            switch($view) {
                case "statements":
                    $this->displayStatements();
                    break;
                case "comments":
                    $this->displayComments();
                    break;
                default:
                    $this->displayStatements();
            }
        }

        function displayStatements() {
            // Get statements
            require_once dirname(__DIR__, 1) . "/models/statements.php";
            $statement = new Statement;
            $statements = $statement->getUserStatements($this->username);


            $variables = [
                "author" => $this->username,
                "statements" => $statements,
            ];

            $this->displayContent("user_profile_statements.pug", $this->username, $variables);
        }

        function displayComments() {            
            // Get comments
            require_once dirname(__DIR__, 1) . "/models/comments.php";
            $comment = new Comment();
            $comments = $comment->getUserComments($this->userId);

            $variables = [
                "author" => $this->username,
                "comments" => $comments,
            ];

            $this->displayContent("user_profile_comments.pug", $this->username, $variables);
        }
    }
?>