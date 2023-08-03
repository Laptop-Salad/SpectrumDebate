<?php
require_once dirname(__DIR__, 3) . "/app/models/Account.php";

use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase {
    public function testFormatTime() {
        $base = new BaseModel;
        $time = $base->formatTime("2022-06-31 17:01:22");

        $this->assertEquals(
            "1 year ago",
            $time,
            "Time was not formatted correctly. Check that time is valid"
        );
    }

    public function testSanitizeInput() {
        $base = new BaseModel;
        $trimmedInput = $base->sanitizeInput("   hello");

        $this->assertEquals(
            "hello",
            $trimmedInput,
            "Input was not santized"
        );
    }
}
?>