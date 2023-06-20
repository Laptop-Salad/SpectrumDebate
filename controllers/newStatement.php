<?php
class NewStatement extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();

        // If request method was not POST direct user to landing page
        if (!$_SESSION["username"]) {
            header("Location:" . "");
            die();
        }

        $this->doCreateStatement();
    }

    function doCreateStatement()
    {
        require $this->connectDB();
        require dirname(__DIR__, 1) . "/models/statements.php";

        $title = $_POST["ns-title"];
        $text = $_POST["ns-text"];
        $username = $_SESSION["username"];

        $statement = new Statement($conn);

        if ($statement->createStatement($username, $title, $text)) {
            header("Location:" . "dashboard");
        } else {
            header("Location:" . "dashboard");
            die();
        }
    }
}
?>