<?php
class Dashboard extends BaseController
{
    function __construct()
    {
        // GET only
        $this->baseConstruct();
        $this->ensureUserLoggedIn("login");
        $statements = $this->doGetStatements();
        $this->displayViews($statements);
    }

    function doGetStatements() {
        /**
         * Creates a Statement model to get all statements from a specific user
         * 
         * @return array of statements
         */
        require_once dirname(__DIR__, 1) . "/models/Statement.php";

        $statement = new Statement;
        $statements = $statement->getUserStatements($_SESSION["username"]);
        return $statements;
    }

    function displayViews($statements)
    {
        /**
         * Prepares to display views
         * 
         * @param array $statements
         */

        $contentVariables = [
            "username" => $_SESSION["username"],
            "statements" => $statements
        ];

        // Display view
        $this->displayContent("dashboard.pug", "Dashboard", $contentVariables);
    }
}
?>