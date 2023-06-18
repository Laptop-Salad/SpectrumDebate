<?php
class Logout extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();
        session_destroy();

        $this->redirectUser();
    }

    function redirectUser()
    {
        header("Location:" . "/");
        die();
    }
}
?>