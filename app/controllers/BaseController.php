<?php
class BaseController
{
    private $forwarding;
    public $domain = "//localhost";
    
    function baseConstruct()
    {
        /**
         * All controllers call this function first
         */
        session_start();
    }

    function ensureUserLoggedIn($redirect = "")
    {
        /**
         * If user isn't logged in, sends user to home
         */
        if (!isset($_SESSION["username"])) {
            echo $this->getRedirect("login");
            die();
        }
    }

    function getRedirect($location = "", $forwarding = "") {
        /**
         * Gets a javascript redirect script
         * 
         * @param string $location where to redirect, e.g. dashboard, login
         * @param string $forwarding states what popup to display, e.g. successful acc. creation
         */
        if ($forwarding == "") {
            return "<script type='text/javascript'>window.location.href='$this->domain/$location'</script>";
        } else {
            return "<script type='text/javascript'>window.location.href='$this->domain/$location?alert=$forwarding'</script>";
        }
    }

    function displayContent($filename, $pageTitle, $variables) {
        /**
         * Displays all required content
         * 
         * @param string $filename the pug/html file to display
         * @param string $pageTitle the title of the page, e.g. Home
         * @param array $variables variables to pass to the pug file
         */

        $variables["domain"] = $this->domain;
        $variables["title"] = $pageTitle;

        // Username to display in navbar
        if (isset($_SESSION["username"])) {
            $variables["username"] = $_SESSION["username"];
        } else {
            $variables["username"] = null;
        };

        Phug::displayFile(dirname(__DIR__, 1) . "/views/favicon.html");
        Phug::displayFile(dirname(__DIR__, 1) . "/views/$filename", $variables);

        // Show forwarded alerts
        $this->showAlert();
    }

    function showAlert() {
        parse_str($_SERVER["QUERY_STRING"], $parameters);

        if (!isset($parameters["alert"])) {
            return;
        }

        switch($parameters["alert"]) {
            case "signup-success":
                echo "
                <script type='text/javascript'>
                Swal.fire({
                    title: 'Success!',
                    text: 'Account created. You can log in now.',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                  })
                </script>";
                break;
            default:
                break;
        }
    }
}
?>
