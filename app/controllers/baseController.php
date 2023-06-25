<?php
class BaseController
{
    function baseConstruct()
    {
        session_start();
    }

    function ensureUserLoggedIn($redirect = "")
    {
        /**
         * if user isn't logged in, sends user to home
         */
        if (!isset($_SESSION["username"])) {
            echo $this->getRedirect("login");
            die();
        }
    }

    function connectDB()
    {
        /**
         * connects to database via config.php script
         */
        return dirname(__DIR__, 2) . "/config/config.php";
    }

    function getRedirect($location = "") {
        return "<script type='text/javascript'>window.location.href='//localhost/$location'</script>";
    }

    function displayHeader($pageTitle) {
        Phug::displayFile(dirname(__DIR__, 1) . "/views/components/header.pug", ["title" => $pageTitle]);
    }

    function displayNavbar() {        
        if (isset($_SESSION["username"])) {
            Phug::displayFile(dirname(__DIR__, 1) . "/views/components/user_navbar.pug", ["username" => $_SESSION["username"]]);
            return;
        } 

        Phug::displayFile(dirname(__DIR__, 1) . "/views/components/navbar.pug");
    }

    function displayContent($filename, $pageTitle, $variables) {
        $variables["domain"] = "//localhost";
        $variables["title"] = $pageTitle;

        if (isset($_SESSION["username"])) {
            $variables["username"] = $_SESSION["username"];
        } else {
            $variables["username"] = null;
        };

        Phug::displayFile(dirname(__DIR__, 1) . "/views/$filename", $variables);
    }
}
?>