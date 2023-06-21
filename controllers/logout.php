<?php
class Logout extends BaseController
{
    function __construct()
    {
        $this->baseConstruct();
        $this->ensureUserLoggedIn();
        session_destroy();
    }
}
?>