<?php
    class UserProfile extends BaseController {
        private $username;
        private $userId;
        private $isFriend;
        function __construct($username, $view) {
            $this->username = $username;
            $this->baseConstruct();

            // Get username
            require_once dirname(__DIR__, 1) . "/models/Account.php";
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

            $this->isFriend = false;

            // Is user friends with the logged in user
            if (isset($_SESSION["username"])) {
                require_once dirname(__DIR__, 1) . "/models/Friend.php";
                $friend = new Friend;
                
                if(!is_null($friend->findFriendship($_SESSION["username"], $this->username))) {
                    $this->isFriend = true;
                }
            }

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
            require_once dirname(__DIR__, 1) . "/models/Statement.php";
            $statement = new Statement;
            $statements = $statement->getUserStatements($this->username);


            $variables = [
                "author" => $this->username,
                "statements" => $statements,
                "isFriend" => $this->isFriend
            ];

            $this->displayContent("user_profile_statements.pug", $this->username, $variables);
        }

        function displayComments() {            
            // Get comments
            require_once dirname(__DIR__, 1) . "/models/Comment.php";
            $comment = new Comment();
            $comments = $comment->getUserComments($this->userId);

            $variables = [
                "author" => $this->username,
                "comments" => $comments,
                "isFriend" => $this->isFriend
            ];

            $this->displayContent("user_profile_comments.pug", $this->username, $variables);
        }
    }
?>