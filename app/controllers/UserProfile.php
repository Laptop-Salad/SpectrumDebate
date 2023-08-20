<?php
    class UserProfile extends BaseController {
        private $username;
        private $userId;
        private $isFriend;
        private $bio;
        function __construct($username) {
            $this->username = $username;
            $this->baseConstruct();

            // Get username
            require_once dirname(__DIR__, 1) . "/models/Account.php";
            $account = new Account();
            $result = $account->findUser($this->username, true);
            $this->userId = $result["id"];
            $this->bio = $result["bio"];

            // If user isn't found don't continue
            if ($this->userId == "") {
                $this->displayContent("user_profile.pug", "404 Not Found", []);
                die();
            }

            // Get properly formatted username
            $this->username = $account->findUserById($this->userId);

            // Is user friends with the logged in user
            $this->isFriend = false;

            if (isset($_SESSION["username"])) {
                require_once dirname(__DIR__, 1) . "/models/Friend.php";
                $friend = new Friend;
                
                if(!is_null($friend->findFriendship($_SESSION["username"], $this->username))) {
                    $this->isFriend = true;
                }
            }

            // Get statements, comments
            $statements = $this->getStatements();
            $comments = $this->getComments();

            $variables = [
                "author" => $this->username,
                "statements" => $statements,
                "comments" => $comments,
                "isFriend" => $this->isFriend,
                "bio" => $this->bio
            ];

            $this->displayContent("user_profile.pug", "@$this->username", $variables);
        }

        function getStatements() {
            // Get statements
            require_once dirname(__DIR__, 1) . "/models/Statement.php";
            $statement = new Statement;
            $statements = $statement->getUserStatements($this->username);

            return $statements;
        }

        function getComments() {            
            // Get comments
            require_once dirname(__DIR__, 1) . "/models/Comment.php";
            $comment = new Comment();
            $comments = $comment->getUserComments($this->userId);

            return $comments;
        }
    }
?>