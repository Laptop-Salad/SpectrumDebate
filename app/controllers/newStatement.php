<?php
class NewStatement extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();
        $this->doCreateStatement();
    }

    function doCreateStatement()
    {
        require dirname(__DIR__, 1) . "/models/statements.php";

        $title = $_POST["ns-title"];
        $text = $_POST["ns-text"];
        $username = $_SESSION["username"];

        $statement = new Statement;
        $base = new BaseController;

        if ($statement->createStatement($username, $title, $text)) {
            echo $base->getRedirect("dashboard");
        } else {
            echo $base->getRedirect("dashboard");
            die();
        }
    }
}
?>