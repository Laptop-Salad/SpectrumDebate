<?php
class NewStatement extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();
        $this->doCreateStatement();
    }

    function doCreateStatement()
    {
        require_once dirname(__DIR__, 1) . "/models/Statement.php";

        $title = $_POST["ns-title"];
        $text = $_POST["ns-text"];
        $username = $_SESSION["username"];

        if (isset($_FILES["ns-image"])) {
            $image = $_FILES["ns-image"];
            require dirname(__DIR__, 1) . "/models/Upload.php";
            $upload = new Upload($username, $image);
            $result = $upload->uploadImage();

            if ($result[0] !== false) {
                $imgUrl = $result[1];
            } else {
                $resultMsg = $result[1];
                $this->displayContent("navbar.pug", "Spectrum Debate", []);
                echo "
                <script type='text/javascript'>
                Swal.fire({
                    title: 'Error!',
                    text: '$resultMsg , file was not uploaded and statement was not created',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href='$this->domain/dashboard'
                    }
                  })
                </script>";
                die();
            }
        }

        $statement = new Statement;
        $base = new BaseController;

        if (isset($imgUrl)) {
            $result = $statement->createStatement($username, $title, $text, $imgUrl);
        } else {
            $result = $statement->createStatement($username, $title, $text);
        }

        if ($result) {
            echo $base->getRedirect("dashboard");
        } else {
            echo $base->getRedirect("dashboard");
            die();
        }
    }
}
?>