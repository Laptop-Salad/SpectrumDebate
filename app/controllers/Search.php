<?php
class Search extends BaseController {
    private $term;
    function __construct($term) {
        /**
         * 
         */
        $this->term = urldecode($term);
        echo json_encode(array(
            "statements" => $this->getLikeStatements(),
            "users" => $this->getLikeUsers()
        ));
    }

    function getLikeStatements() {
        /**
         * @return array[array]
         */
        require_once dirname(__DIR__, 1) . "/models/Statement.php";
        $statement = new Statement;
        $data = $statement->getLikeStatements($this->term);
        return $data;
    }

    function getLikeUsers() {
        /**
         * @return array[array]
         */
        require_once dirname(__DIR__, 1) . "/models/Account.php";
        $account = new Account;
        $data = $account->getLikeUsers($this->term);
        return $data;
    }
}
?>