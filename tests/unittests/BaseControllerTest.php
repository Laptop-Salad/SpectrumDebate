<?php

require dirname(__DIR__, 2) . "/app/controllers/BaseController.php";

use PHPUnit\Framework\TestCase;

final class BaseControllerTest extends TestCase {
    public function testClassConstructor() {
        $base = new BaseController;
        $base->baseConstruct();

        $this->assertEquals(session_status(), PHP_SESSION_ACTIVE);
    }

    public function testGetRedirect() {
        $base = new BaseController;
        $redirect = $base->getRedirect("dashboard", "");

        $this->assertEquals($redirect, "<script type='text/javascript'>window.location.href='//localhost/dashboard'</script>");
    }
}

?>