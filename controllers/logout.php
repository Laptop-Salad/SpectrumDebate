<?php
class Logout extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();
        session_destroy();

        $this->redirectUser();
    }

    function redirectUser()
    {
        $base = new BaseController;
        echo $base->getRedirect("");
        die();
    }
}
?>