<?php
class BaseController
{
    function baseConstruct()
    {
        session_start();
        Phug::displayFile(dirname(__DIR__, 1) . "/views/favicon.html");
    }

    function ensureUserLoggedIn()
    {
        /**
         * if user isn't logged in, sends user to home
         */
        if (!$_SESSION["username"]) {
            header("Location:" . "");
            die();
        }
    }

    function connectDB()
    {
        /**
         * connects to database via config.php script
         */
        return dirname(__DIR__, 1) . "/config/config.php";
    }
}
?>