<?php
require_once "baseModel.php";

class Statement extends BaseModel
{
    public $account;

    function __construct()
    {
        $this->connectDB();
        require_once "accounts.php";
        $account = new Account;
        $this->account = $account;
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
        $userid = $this->account->findUser($username);
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

    function updateStatement($statementId, $title, $text) {
        /**
         * updates a statement in the database
         * 
         * @param string $statementId
         * @param string $title
         * @param string $text
         * @return bool if statement was successfully uploaded
         */
        $statementId = $this->sanitizeInput($statementId);
        $title = $this->sanitizeInput($title);
        $text = $this->sanitizeInput($text);
        
        // Prepare and bind statement
        $stmt = $this->conn->prepare("UPDATE statements
        SET title = ?, text = ?
        WHERE id = ?");
        $stmt->bind_param("sss", $title, $text, $statementId);

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
                $username = $this->account->findUserById($row["author_id"]);

                // Format time 
                $formattedTime = $this->formatTime($row["timestamp"]);
                
                array_push($data, array(
                    $row["id"],
                    $username,
                    $row["title"],
                    $row["text"],
                    $formattedTime,
                ));
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
        $user_id = $this->account->findUser($username);

        // Prepare and bin statement
        $stmt = $this->conn->prepare("SELECT * FROM statements WHERE author_id = ?");
        $stmt->bind_param("s", $user_id);

        // Execute statement
        $result = $stmt->execute();
        $result = $stmt->get_result();

        // Create array to save result to
        $data = array();

        while ($row = $result->fetch_assoc()) {
            // Get username
            $username = $this->account->findUserById($row["author_id"]);

            // Format time 
            $formattedTime = $this->formatTime($row["timestamp"]);

            array_push($data, array(
                $row["id"],
                $username,
                $row["title"],
                $row["text"],
                $formattedTime,
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
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Lookup users username by user id
                $username = $this->account->findUserById($row["author_id"]);

                // Format time
                $formattedTime = $this->formatTime($row["timestamp"]);
                
                // Place data in array
                $data["id"] = $row["id"];
                $data["author"] = $username;
                $data["title"] = $row["title"];
                $data["text"] = $row["text"];
                $data["time"] = $formattedTime;
            }
        }

        return $data;
    }

    function formatTime($timestamp) {
        /**
         * returns a formatted string of a time string
         * 
         * @param string $timestamp
         * @return string
         */
        
        $datetime = strtotime($timestamp);
        
        $time = date("H", $datetime) . ":" . date("s", $datetime);
        $dayOfMonth = date("j", $datetime) . date("S", $datetime);
        $month = date("F");
        $year = date("Y");

        return "at " . $time . " on the " . $dayOfMonth . " of " . $month . ", " . $year;
    }
}
?>