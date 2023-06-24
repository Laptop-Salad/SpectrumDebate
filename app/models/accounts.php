<?php
require_once "baseModel.php";

class Account extends BaseModel
{
    function createUser($conn, $username, $userpass)
    {
        /**
         * creates a user
         * 
         * @param mysqli $conn
         * @param string $username
         * @param string $password
         * @return bool True = user was created
         */

        $username = $this->sanitizeInput($username);
        $userpass = $this->sanitizeInput($userpass);

        // Prepare and bind statement
        $sqlStmt = $conn->prepare("INSERT INTO users (username, password) 
        VALUES (?, ?)");
        $sqlStmt->bind_param("ss", $username, $userpass);
    
        // Execute statement
        if ($sqlStmt->execute()) {
            return True;
        } else {
            return False;
        }
    }
    
    function checkCredentials($conn, $username, $userpass)
    {
        /**
         * checks that the user's username and password exist
         * 
         * @param mysqli $conn
         * @param string $username
         * @param string $password
         * @return bool True = if username and password exists
         */

        // Bind and prepare statement
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $userpass);

        // Execute statement
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return True;
        } else {
            return False;
        }
    }
    
    function findUser($conn, $username)
    {
        /**
         * checks that a username exists
         * 
         * @param mysqli $conn
         * @param string $username
         * @return bool|int integer is found userid
         */

        // Prepare and bind statement
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);

        // Execute and bind result
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["id"];
            }
        }
    }
    
    function findUserById($conn, $userid)
    {
        /**
         * gets a username from a userid
         * @param mysqli $conn
         * @param string $userid
         * @return string|bool string if username is found
         */

        // Prepare and bind statement
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("s", $userid);
        
        // Execute and bind result
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["username"];
            }
        }
    }
}
?>