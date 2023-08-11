<?php
class Dashboard extends BaseController
{
    private $friend;
    function __construct()
    {
        // GET only
        $this->baseConstruct();
        $this->ensureUserLoggedIn("login");

        // Instantiate friend
        require_once dirname(__DIR__, 1) . "/models/Friend.php";
        $this->friend = new Friend;

        $statements = $this->getStatements();
        $comments = $this->getComments();
        $follows = $this->getFollows();
        $followers = $this->getFollowers();

        $this->displayViews($statements, $follows, $followers, $comments);
    }

    function getFollowers() {
        return $this->friend->getUserFollowers($_SESSION["username"]);
    }

    function getFollows() {
        return $this->friend->getUserFollows($_SESSION["username"]);
    }

    function getComments() {
        require_once dirname(__DIR__, 1) . "/models/Comment.php";
        require_once dirname(__DIR__, 1) . "/models/Account.php";

        $account = new Account;
        $userId = $account->findUser($_SESSION["username"]);

        $comment = new Comment;
        return $comment->getUserComments($userId);
    }

    function getStatements() {
        require_once dirname(__DIR__, 1) . "/models/Statement.php";

        $statement = new Statement;
        $statements = $statement->getUserStatements($_SESSION["username"]);
        return $statements;
    }

    function displayViews($statements, $follows, $followers, $comments)
    {
        /**
         * Prepares to display views
         * 
         * @param array $statements
         */

        $contentVariables = [
            "username" => $_SESSION["username"],
            "statements" => $statements,
            "follows" => $follows,
            "followers" => $followers,
            "comments" => $comments
        ];

        // Display view
        $this->displayContent("dashboard.pug", "Dashboard", $contentVariables);
    }
}
?>