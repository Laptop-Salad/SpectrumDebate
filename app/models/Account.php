<?php
use PHPUnit\Framework\Constraint\IsEmpty;
require_once "BaseModel.php";

class Account extends BaseModel
{
    function __construct() {
        $this->connectDB();
    }

    function createUser($username, $userpass)
    {
        /**
         * creates a user
         * 
         * @param string $username
         * @param string $password
         * @return bool True = user was created
         */

        $username = $this->sanitizeInput($username);
        $userpass = $this->sanitizeInput($userpass);

        $userpass = password_hash($userpass, PASSWORD_DEFAULT);

        // Prepare and bind statement
        $sqlStmt = $this->conn->prepare("INSERT INTO users (username, password) 
        VALUES (?, ?)");
        $sqlStmt->bind_param("ss", $username, $userpass);
    
        // Execute statement
        if ($sqlStmt->execute()) {
            return True;
        } else {
            return False;
        }
    }

    function deleteUser($userid)
    {
        /**
         * creates a user
         * 
         * @param string $userid
         * @return bool True = user was deleted
         */


        // Check if user id exists
        if (is_null($this->findUserById($userid))) {
            return false;
        }

        // Prepare and bind statement
        $sqlStmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $sqlStmt->bind_param("s", $userid);
        
        return $sqlStmt->execute();
    }
    
    function checkCredentials($username, $userpass)
    {
        /**
         * checks that the user's username and password exist
         * 
         * @param string $username
         * @param string $userpass
         * @return bool True = if username and password exists
         */

        $username = $this->sanitizeInput($username);
        $userpass = $this->sanitizeInput($userpass);

        // Get the full details of the user
        $user = $this->findUser($username, true);

        if (!$user) {
            return False;
        }
    
        if (password_verify($userpass, $user["password"])) {
            return True;
        } else {
            return False;
        }
    }
    
    function findUser($username, $full = False)
    {
        /**
         * checks that a username exists
         * 
         * @param string $username
         * @param bool $full if the full user details are required or just the user id
         * @return string empty|int integer is found userid| array if the $full param is true
         */

        // Prepare and bind statement
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);

        // Execute and bind result
        $stmt->execute();
        $result = $stmt->get_result();
        
        // If the full details of the user is required
        if ($full) {
            while ($row = $result->fetch_assoc()) {
                return array(
                    "id" => $row["id"],
                    "username" => $row["username"],
                    "password" => $row["password"],
                    "bio" => $row["bio"]
                );
            }
        }

        // If only the userid is required
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["id"];
            }
        }
    }
    
    function updateUserVars($username, $bio) {
        /**
         * updates user account for details that can be changed
         * 
         * @param string $username username to details for
         * @param string $bio if bio is to be updated
         * @return bool if update was successful
         */

         $stmt = $this->conn->prepare("UPDATE users SET bio = ? WHERE username = ?;");
         $stmt->bind_param("ss", $bio, $username);
         
         if ($stmt->execute()) {
             return True;
         } else {
             return False;
         }
    }

    function findUserById($userid)
    {
        /**
         * gets a username from a userid
         * @param mysqli $conn
         * @param string $userid
         * @return string|bool string if username is found
         */

        // Prepare and bind statement
        $stmt = $this->conn->prepare("SELECT username FROM users WHERE id = ?");
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

    function getLikeUsers($term)
    {
        /**
         * find users whose username contains $term
         * 
         * @param string $term username should contain
         * @return array[array] of users
         */

        if (empty($term)) {return [];};

        $term = "%$term%";
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE lower(username) LIKE lower(?)");
        $stmt->bind_param("s", $term);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($data, array(
                    "id" => $row["id"],
                    "username" => $row["username"]
                ));
            }
        }

        return $data;
    }
}
?>