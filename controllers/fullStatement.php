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

            // Display views
            $this->displayHeader($data[2]);
            $this->displayNavbar();
            Phug::displayFile(dirname(__DIR__, 1) . "/views/full_statement.pug", $contentVariables);    
        }
    }
?>