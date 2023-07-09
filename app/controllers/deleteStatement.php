<?php
class DeleteStatement extends BaseController {
    function __construct($statementId) {
        require_once dirname(__DIR__ , 1) . "/models/statements.php";
        require_once dirname(__DIR__, 1) . "/models/accounts.php";

        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        $statement = new Statement;
        $currStatement = $statement->getStatementById($statementId);

        // If statement doesn't exist
        if (count($currStatement) == 0) {
            $this->displayContent("error.pug", "404 Statement Not Found", ["item" => "Statement"]);
            die();
        }

        // If user doesn't own statement
        if ($currStatement["author"] != $_SESSION["username"]) {
            echo $this->getRedirect();
            die();
        }

        $statement->deleteStatement($statementId);
        echo $this->getRedirect("dashboard");
    }
}
?>