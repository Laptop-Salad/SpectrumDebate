<?php
class DeleteStatement extends BaseController {
    private $currStatement;
    function __construct($statementId) {
        require_once dirname(__DIR__ , 1) . "/models/Statement.php";
        require_once dirname(__DIR__, 1) . "/models/Account.php";

        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        $statement = new Statement;
        $currStatement = $statement->getStatementById($statementId);
        $this->currStatement = $currStatement;

        $this->checkDeleteValid();

        // If delete is valid, delete statement
        $statement->deleteStatement($statementId);
        echo $this->getRedirect("dashboard");
    }

    function checkDeleteValid() {
        // If statement doesn't exist
        if (count($this->currStatement) == 0) {
            $this->displayContent("error.pug", "404 Statement Not Found", ["item" => "Statement"]);
            die();
        }

        // If user doesn't own statement
        if ($this->currStatement["author"] != $_SESSION["username"]) {
            echo $this->getRedirect();
            die();
        }
    }
}
?>