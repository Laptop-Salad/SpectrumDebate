<?php 
    class NotFound extends BaseController{
        function __construct() {
            $this->displayViews();
        }

        function displayViews() {
            $this->displayContent("error.pug", "404 Not Found", []);
        }
    }
?>