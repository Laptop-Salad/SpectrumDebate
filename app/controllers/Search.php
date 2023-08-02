<?php
class Search extends BaseController {
    private $term;
    function __construct($term) {
        $this->term = $term;
    }

    function getLikeStatements() {
        require dirname(__DIR__, 1) . "/models/Statement.php";
        $statement = new Statement;
        echo $statement->getLikeStatements($this->term);
    }
}
?>