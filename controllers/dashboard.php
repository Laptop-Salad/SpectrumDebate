<?php
class Dashboard extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();
        $this->ensureUserLoggedIn("login");
        $statements = $this->doGetStatements();
        $this->displayViews($statements);
    }

    function doGetStatements() {
        /**
         * creates a Statement model to get all statements from a specific user
         * 
         * @return array of statements
         */
        require $this->connectDB();
        include dirname(__DIR__, 1) . "/models/statements.php";

        $statement = new Statement($conn);
        $statements = $statement->getUserStatements($_SESSION["username"]);
        return $statements;
    }

    function displayViews($statements)
    {
        /**
         * displays a view
         * 
         * - header
         * - navbar (user_navbar)
         * - content
         * 
         * @param array $statements array of statements
         */

        $contentVariables = [
            "logo" => dirname(__DIR__, 1) . "/views/assets/logo.png",
            "statements" => $statements
        ];

        // Display view
        $this->displayContent("dashboard.pug", "Dasboard", $contentVariables);
    }
}
?>