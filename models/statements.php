<?php
require "accounts.php";
require_once "baseModel.php";

class Statement extends BaseModel
{
    public $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function createStatement($username, $title, $text)
    {
        /**
         * uploads statement to database
         * 
         * @param string $username
         * @param string $title
         * @param string $text
         * @return bool if statement was successfully uploaded
         */

        $username = $this->sanitizeInput($username);
        $title = $this->sanitizeInput($title);
        $text - $this->sanitizeInput($text);

        $account = new Account;
        $userid = $account->findUser($this->conn, $username);
        if (!$userid) {
            return False;
        }

        $sql = "INSERT INTO statements (author_id, title, text)
            VALUES ('$userid', '$title', '$text')";
        $result = $this->conn->query($sql);

        if ($result) {
            return True;
        } else {
            return False;
        }
    }

    function getAllStatements()
    {
        /**
         * get all statements from database
         * 
         * @return array of statements
         */
        $sql = "SELECT * FROM statements";
        $result = $this->conn->query($sql);
        $data = array();
        $account = new Account;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $username = $account->findUserById($this->conn, $row["author_id"]);
                array_push($data, array(
                    $row["id"],
                    $username,
                    $row["title"],
                    $row["text"],
                    $row["timestamp"],
                )
                );
            }
        }

        return $data;
    }

    function getUserStatements($username)
    {
        /**
         * get all statements from a specific user
         * 
         * @param string $username
         * @return array of statements
         */
        $account = new Account;
        $user_id = $account->findUser($this->conn, $username);
        $sql = "SELECT * FROM statements WHERE author_id = '$user_id'";
        $result = $this->conn->query($sql);

        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $username = $account->findUserById($this->conn, $row["author_id"]);
                array_push($data, array(
                    $row["id"],
                    $username,
                    $row["title"],
                    $row["text"],
                    $row["timestamp"],
                )
                );
            }
        }

        return $data;
    }
}
?>