<?php
class Logout extends BaseController
{
    function __construct($bypass = False)
    {
        $this->baseConstruct();

        if (!$bypass) {
            $this->ensureUserLoggedIn();
        }

        session_destroy();
        echo $this->getRedirect("");
    }
}
?>