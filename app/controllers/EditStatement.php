<?php
class EditStatement extends BaseController {
    function __construct($statementId) {
        require_once dirname(__DIR__, 1) . "/models/Statement.php";
        $this->baseConstruct();
        $this->ensureUserLoggedIn();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $text = $_POST["text"];

            if(file_exists($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
                $image = $_FILES["image"];
                require dirname(__DIR__, 1) . "/models/Upload.php";
                $upload = new Upload($_SESSION["username"], $image);
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
                        text: '$resultMsg , file was not uploaded and statement was not updated',
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

            if (isset($imgUrl)) {
                $result = $statement->updateStatement($statementId, $title, $text, $imgUrl);;
            } else {
                $result = $statement->updateStatement($statementId, $title, $text);;
            }

            if (!$result) {
                $this->displayContent("navbar.pug", "Spectrum Debate", []);
                echo "
                <script type='text/javascript'>
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error updating your statement , Please try again later',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href='$this->domain/statement/$statementId'
                    }
                  })
                </script>";
                die();
            }
    
            echo $this->getRedirect("statement/$statementId");
        }

        $statement = $this->doGetStatement($statementId);

        // Ensure user actually authored this statement
        if ($_SESSION["username"] != $statement["author"]) {
            echo $this->getRedirect();
            die();
        }

        $variables = [
            "statement" => $statement,
            "edit_statement" => true,
        ];

        $this->displayContent("edit_statement.pug", "Editing " . $statement["title"], $variables);
    }

    function doGetStatement($statementId) {
        $statement = new Statement;
        $currStatement = $statement->getStatementById($statementId);
        return $currStatement;
    }
}
?>