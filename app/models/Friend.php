<?php
require_once "BaseModel.php";

class Friend extends BaseModel {
    function __construct() {
        $this->connectDB();
    }

    function createFriend($fromUser, $toUser) {
        /**
         * creates friendship in database
         * 
         * @param string $fromUser username of user trying to befriend $toUser
         * @param string $toUser
         * @return bool if friendship was successfully created
         */

        require_once "Account.php";
        $account = new Account;

        $username = $this->sanitizeInput($fromUser);
        $title = $this->sanitizeInput($toUser);

        // Get to user's user id
        $toUserid = $account->findUser($toUser);
        if (!$toUserid) {
            return False;
        }

        // Get from user's user id
        $fromUserid = $account->findUser($fromUser);
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

    function findFriendship($fromUser, $toUser) {
        /**
         * finds a friendship in database
         * 
         * @param string $fromUser username of user who befriended $toUser
         * @param string $toUser
         * @return null | int id of friendship
         */

         require_once "Account.php";
         $account = new Account;
 
         $username = $this->sanitizeInput($fromUser);
         $title = $this->sanitizeInput($toUser);
 
         // Get to user's user id
         $toUserid = $account->findUser($toUser);
         if (!$toUserid) {
             return null;
         }
 
         // Get from user's user id
         $fromUserid = $account->findUser($fromUser);
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

    function deleteFriendship($fromUser, $toUser) {
        $frienshipId = $this->findFriendship($fromUser, $toUser);

        if (is_null($frienshipId)) {
            return false;
        }
        
        // Prepare and bind statement
        $stmt = $this->conn->prepare("DELETE FROM friends
        WHERE id = ?");
        $stmt->bind_param("s", $frienshipId);
        return $stmt->execute();
    }
}

?>