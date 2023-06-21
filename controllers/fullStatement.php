<?php
    class fullStatement extends BaseController {
        function __construct($id) {
            $this->baseConstruct();
            require dirname(__DIR__, 1) . "/models/statements.php";
            require $this->connectDB();
            $statement = new Statement($conn);
            $data = $statement->getStatementById($id);

            $headerVariables = [
                "title" => "Dashboard",
            ];
    
            $contentVariables = [
                "statement" => $data,
            ];    
            // Display views
            Phug::displayFile(dirname(__DIR__, 1) . "/views/components/header.pug", $headerVariables);
            Phug::displayFile(dirname(__DIR__, 1) . "/views/components/navbar.pug");
            Phug::displayFile(dirname(__DIR__, 1) . "/views/full_statement.pug", $contentVariables);    
        }
    }
?>