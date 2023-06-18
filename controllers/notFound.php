<?php 
    class NotFound {
        function __construct() {
            $this->displayViews();
        }

        function displayViews() {
            $headerVariables = [
                "title" => "404 Not Found",
            ];
            Phug::displayFile(dirname(__DIR__, 1) . "/views/components/header.pug", $headerVariables);
            Phug::displayFile(dirname(__DIR__, 1) . "/views/components/navbar.pug");
            Phug::displayFile(dirname(__DIR__, 1) . "/views/error.pug");
        }
    }
?>