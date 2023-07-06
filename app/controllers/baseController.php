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

    function getRedirect($location = "") {
        return "<script type='text/javascript'>window.location.href='//localhost/$location'</script>";
    }

    function displayContent($filename, $pageTitle, $variables, $stylesheet = null) {
        $variables["domain"] = "//localhost";
        $variables["title"] = $pageTitle;

        if (isset($_SESSION["username"])) {
            $variables["username"] = $_SESSION["username"];
        } else {
            $variables["username"] = null;
        };

        Phug::displayFile(dirname(__DIR__, 1) . "/views/favicon.html");
        Phug::displayFile(dirname(__DIR__, 1) . "/views/$filename", $variables);
    }

    function displayNotif($type, $message) {
        switch ($type) {
            case "error":
                $class = "notif-error";
                break;
            case "success":
                $class = "notif-success";
                break;
            default:
                $class = "notif-neutral";
        }

        echo "<script type='text/javascript'>",
        "const dialog = document.getElementById('notif');",
        "dialog.open = true;",
        "dialog.setAttribute('class', '$class');",
        "document.getElementById('notifMessage').innerHTML = '$message';",
        "</script>";
    }
}
?>