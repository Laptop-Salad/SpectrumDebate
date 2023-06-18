<?php
class Dashboard extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();
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
        // Set up variables required for views
        $username = $_SESSION["username"];

        $headerVariables = [
            "title" => "Dashboard"
        ];

        $navVariables = [
            "username" => $username
        ];

        $contentVariables = [
            "logo" => dirname(__DIR__, 1) . "/views/assets/logo.png",
            "statements" => $statements
        ];

        // Display views
        Phug::displayFile(dirname(__DIR__, 1) . "/views/components/header.pug", $headerVariables);
        Phug::displayFile(dirname(__DIR__, 1) . "/views/components/user_navbar.pug", $navVariables);
        Phug::displayFile(dirname(__DIR__, 1) . "/views/dashboard.pug", $contentVariables);
    }
}
?>