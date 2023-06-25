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
        $text = $this->sanitizeInput($text);

        // Get user's user id
        $account = new Account;
        $userid = $account->findUser($this->conn, $username);
        if (!$userid) {
            return False;
        }
        
        // Prepare and bind statement
        $stmt = $this->conn->prepare("INSERT INTO statements (author_id, title, text)
            VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $userid, $title, $text);

        if ($stmt->execute()) {
            return True;
        } 

        return False;
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

        // Create array to hold results
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Look up user's username by id
                $account = new Account;
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

        // Get user's user id
        $account = new Account;
        $user_id = $account->findUser($this->conn, $username);

        // Prepare and bin statement
        $stmt = $this->conn->prepare("SELECT * FROM statements WHERE author_id = ?");
        $stmt->bind_param("s", $user_id);

        // Execute statement
        $result = $stmt->execute();
        $result = $stmt->get_result();

        // Create array to save result to
        $data = array();

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

        return $data;
    }

    function getStatementById($id) {
        /**
         * get statements by id of statement
         * @param string $id of statement
         */

        // Prepare and bind statement
        $stmt = $this->conn->prepare("SELECT * FROM statements WHERE id = ?");
        $stmt->bind_param("s", $id);

        // Execute statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Create data to hold result
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Lookup users username by user id
                $account = new Account;
                $username = $account->findUserById($this->conn, $row["author_id"]);
                        
                array_push($data,
                    $row["id"],
                    $username,
                    $row["title"],
                    $row["text"],
                    $row["timestamp"],
                );
            }
        }

        return $data;
    }
}
?>