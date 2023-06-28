<?php
class EditStatement extends BaseController {
    function __construct($statementId) {
        require dirname(__DIR__, 1) . "/models/statements.php";
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $text = $_POST["text"];
            
            $statement = new Statement;
            $statement->updateStatement($statementId, $title, $text);

            echo $this->getRedirect("statement/$statementId");
        }

        $statement = $this->doGetStatement($statementId);

        // Ensure user actually authored this statement
        if ($_SESSION["username"] != $statement["author"]) {
            echo $this->getRedirect();
            die();
        }

        $variables = [
            "statement" => $statement
        ];

        $this->displayContent("edit_statement.pug", "Editing " . $statement["title"], $variables);
    }

    function doGetStatement($statementId) {
        $statement = new Statement;
        $currStatement = $statement->getStatementById($statementId);
        return $currStatement;
    }
}
?>