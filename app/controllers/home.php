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

        $this->displayContent("home.pug", "Home", $contentVariables);
    }
}
?>