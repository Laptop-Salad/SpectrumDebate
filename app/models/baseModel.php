<?php
    class BaseModel {
        public $conn;
        function sanitizeInput($input) {
            $input = trim($input);
            $input = addslashes($input);

            return $input;
        } 

        function connectDB() {
            require dirname(__DIR__, 2) . "/config/config.php";
            $this->conn = $conn;
        }

    }
?>