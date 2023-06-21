<?php
    class fullStatement extends BaseController {
        function __construct($id) {
            $this->baseConstruct();
            require dirname(__DIR__, 1) . "/models/statements.php";
            require $this->connectDB();
            $statement = new Statement($conn);
            $data = $statement->getStatementById($id);
            echo implode($data);
        }
    }
?>