<?php
require_once "BaseModel.php";

class Friend extends BaseModel {
    function __construct() {
        $this->connectDB();
    }

    function createFriend($fromUsername, $toUsername) {
        /**
         * creates friendship in database
         * 
         * @param string $fromUsername username of user trying to befriend $toUser
         * @param string $toUsername
         * @return bool if friendship was successfully created
         */

        require_once "Account.php";
        $account = new Account;

        $username = $this->sanitizeInput($fromUsername);
        $title = $this->sanitizeInput($toUsername);

        // Get to user's user id
        $toUserid = $account->findUser($toUsername);
        if (!$toUserid) {
            return False;
        }

        // Get from user's user id
        $fromUserid = $account->findUser($fromUsername);
        if (!$fromUserid) {
            return False;
        }
        
        // Prepare and bind statement
        $stmt = $this->conn->prepare("INSERT INTO friends (user_id_from, user_id_to)
            VALUES (?, ?)");
        $stmt->bind_param("ss", $fromUserid, $toUserid);

        if ($stmt->execute()) {
            return True;
        } 

        return False;
    }

    function findFriendship($fromUsername, $toUsername) {
        /**
         * finds a friendship in database
         * 
         * @param string $fromUsername username of user who befriended $toUser
         * @param string $toUsername
         * @return null | int id of friendship
         */

         require_once "Account.php";
         $account = new Account;
 
         $username = $this->sanitizeInput($fromUsername);
         $title = $this->sanitizeInput($toUsername);
 
         // Get to user's user id
         $toUserid = $account->findUser($toUsername);
         if (!$toUserid) {
             return null;
         }
 
         // Get from user's user id
         $fromUserid = $account->findUser($fromUsername);
         if (!$fromUserid) {
             return null;
         }
         
         // Prepare and bind statement
         $stmt = $this->conn->prepare("SELECT id FROM friends WHERE user_id_from = ? AND user_id_to = ?");
         $stmt->bind_param("ss", $fromUserid, $toUserid);
         $stmt->execute();
         $result = $stmt->get_result();

         while ($row = $result->fetch_assoc()) {
            if ($row["id"]) {
                return $row["id"];
            }
         }
 
         return null;
    }

    function deleteFriendship($fromUsername, $toUsername) {
        $frienshipId = $this->findFriendship($fromUsername, $toUsername);

        if (is_null($frienshipId)) {
            return false;
        }
        
        // Prepare and bind statement
        $stmt = $this->conn->prepare("DELETE FROM friends
        WHERE id = ?");
        $stmt->bind_param("s", $frienshipId);
        return $stmt->execute();
    }

    function getUserFollows($username) {
        /**
         * get all users $user is following
         * 
         * @param string $username
         * @return array of friends
         */

        $account = new Account;

        // Get user's user id
        $userId = $account->findUser($username);

        // Prepare and bin statement
        $stmt = $this->conn->prepare("SELECT * FROM friends WHERE user_id_from = ?");
        $stmt->bind_param("s", $userId);

        // Execute statement
        $result = $stmt->execute();
        $result = $stmt->get_result();

        $data = array();

        while ($row = $result->fetch_assoc()) {
            // Get friend's username
            $friend = $account->findUserById($row["user_id_to"]);

            array_push($data, array(
                "id" => $row["id"],
                "username" => $friend,
            )
            );
        }

        return $data;
    }

    function getUserFollowers($username) {
        /**
         * get all users that is following $user
         * 
         * @param string $username
         * @return array of friends
         */

        $account = new Account;

        // Get user's user id
        $userId = $account->findUser($username);

        // Prepare and bin statement
        $stmt = $this->conn->prepare("SELECT * FROM friends WHERE user_id_to = ?");
        $stmt->bind_param("s", $userId);

        // Execute statement
        $result = $stmt->execute();
        $result = $stmt->get_result();

        $data = array();

        while ($row = $result->fetch_assoc()) {
            // Get followers's username
            $friend = $account->findUserById($row["user_id_from"]);

            array_push($data, array(
                "id" => $row["id"],
                "username" => $friend,
            )
            );
        }

        return $data;

    }

}

?>