<?php
class Home extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();
        $statements = $this->doGetStatements();
        $this->displayViews($statements);
    }

    function doGetStatements()
    {
        /**
         * gathers all the statements in the database
         * 
         * @return array of statements
         */
        require $this->connectDB();
        include dirname(__DIR__, 1) . "/models/statements.php";

        $statement = new Statement($conn);
        $statements = $statement->getAllStatements();

        return $statements;
    }

    function displayViews($statements)
    {
        /**
         * displays a view
         * 
         * - header
         * - navbar | user_navbar if user is logged in otherwise default navbar
         * 
         * @param array $statements an array of statements
         */
        $contentVariables = [
            "statements" => $statements,
        ];

        $headVariables = [
            "title" => "Home",
        ];

        // Display header
        Phug::displayFile(dirname(__DIR__, 1) . "/views/components/header.pug", $headVariables);

        // If user is logged in display user_navbar
        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
            $navbarVariables = [
                "username" => $username,
            ];

            Phug::displayFile(dirname(__DIR__, 1) . "/views/components/user_navbar.pug", $navbarVariables);
            // Otherwise display default navbar   
        } else {
            Phug::displayFile(dirname(__DIR__, 1) . "/views/components/navbar.pug");
        }

        // Display content
        Phug::displayFile(dirname(__DIR__, 1) . "/views/home.pug", $contentVariables);
    }
}
?>