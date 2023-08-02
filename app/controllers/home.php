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
        require_once dirname(__DIR__, 1) . "/models/Statement.php";

        $statement = new Statement;
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