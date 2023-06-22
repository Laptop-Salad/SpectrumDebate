<?php 
    class NotFound extends BaseController{
        function __construct() {
            $this->displayViews();
        }

        function displayViews() {
            $this->displayHeader("404 Not Found");
            $this->displayNavbar();
            Phug::displayFile(dirname(__DIR__, 1) . "/views/error.pug");
        }
    }
?>