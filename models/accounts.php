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

        $sql = "INSERT INTO users (username, password) 
            VALUES ('$username', '$userpass')";
    
        if ($conn->query($sql)) {
            return True;
        } else {
            echo "Error: " . mysqli_error($conn);
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
        $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$userpass'";
        $result = $conn->query($sql);
    
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
        $sql = "SELECT id FROM users WHERE username = '$username'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["id"];
            }
        } else {
            return False;
        }
    }
    
    function findUserById($conn, $userid)
    {
        $sql = "SELECT username FROM users WHERE id = '$userid'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["username"];
            }
        } else {
            return False;
        }
    }
}
?>