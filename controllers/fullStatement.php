<?php
    class fullStatement extends BaseController {
        function __construct($id) {
            $this->baseConstruct();
            require dirname(__DIR__, 1) . "/models/statements.php";
            require $this->connectDB();
            $statement = new Statement($conn);
            $data = $statement->getStatementById($id);
    
            $contentVariables = [
                "statement" => $data,
            ];    

            // Display view
            $this->displayContent("full_statement.pug", $data[2], $contentVariables);
        }
    }
?>