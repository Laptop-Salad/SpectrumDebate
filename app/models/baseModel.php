<?php
    class BaseModel {
        function sanitizeInput($input) {
            $input = trim($input);
            $input = addslashes($input);

            return $input;
        } 

    }
?>