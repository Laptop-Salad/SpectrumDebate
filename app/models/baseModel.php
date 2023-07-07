<?php
    class BaseModel {
        public $conn;
        function sanitizeInput($input) {
            $input = trim($input);

            return $input;
        } 

        function connectDB() {
            require dirname(__DIR__, 2) . "/config/config.php";
            $this->conn = $conn;
        }

        function formatTime($timestamp) {
            // Set correct timezone
            date_default_timezone_set('Europe/London');

            // Get times
            $now = strtotime(date("Y-m-d H:i:s", time())); 
            $timestamp = strtotime($timestamp);

            $difference = $now - $timestamp;

            $strTime = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
            $intTime = array("60","60","24","7","4.35","12","10");
            
            /* 
            Loop through times until it can't divide anymore 
            Example: 
            difference = 3600 (1 hour = 3600s)
            3600 / 60 = 60 | "second"
            60 is not less than 60 | "minute"
            60 / 60 = 1 | "minute"
            1 is less than 24 | "hour"
            answer = 1 hour
            
            */
            for($j = 0; $difference >= $intTime[$j] && $j < count($intTime)-1; $j++) {
                $difference /= $intTime[$j];
            }
            
            $difference = round($difference);
            
            if($difference != 1) {
                $strTime[$j].= "s";
            }
         
            return "$difference $strTime[$j] ago";
        }
        
    }
?>