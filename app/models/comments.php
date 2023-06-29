<?php
    require_once "baseModel.php";

    class Comment extends BaseModel {
        private $account;
        function __construct() {            
            require_once "accounts.php";
            $this->account = New Account;
            $this->connectDB();
        }

        function createNewComment($statement_id, $comment, $username) {
            $userid = $this->account->findUser($username);

            $stmt = $this->conn->prepare("INSERT INTO comments (statement_id, author_id, text)
            VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $statement_id, $userid, $comment);
            
            if($stmt->execute()) {
                return True;
            }

            return False;
        }

        function deleteComment($commentId) {
            $stmt = $this->conn->prepare("DELETE FROM comments WHERE id = ?");
            $stmt->bind_param("s", $commentId);
            
            if($stmt->execute()) {
                return True;
            }

            return False;
        }

        function getStatementComments($statement_id) {
            $stmt = $this->conn->prepare("SELECT * FROM comments WHERE statement_id = ?");
            $stmt->bind_param("s", $statement_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = array();

            while ($row = $result->fetch_assoc()) {
                $username = $this->account->findUserById($row["author_id"]);
                array_push($data, array(
                    $row["id"],
                    $row["statement_id"],
                    $username,
                    $row["text"]
                ));
            }

            return $data;
        }

        function getUserComments($userId) {
            $stmt = $this->conn->prepare("SELECT * FROM comments WHERE author_id = ?");
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = array();

            while ($row = $result->fetch_assoc()) {
                $username = $this->account->findUserById($row["author_id"]);
                array_push($data, array(
                    $row["id"],
                    $row["statement_id"],
                    $username,
                    $row["text"]
                ));
            }

            return $data;
        }

        function getCommentById($commentId) {
            $stmt = $this->conn->prepare("SELECT * FROM comments WHERE id = ?");
            $stmt->bind_param("s", $commentId);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = array();

            while ($row = $result->fetch_assoc()) {
                $username = $this->account->findUserById($row["author_id"]);
                array_push($data, 
                    $row["id"],
                    $row["statement_id"],
                    $username,
                    $row["text"]
                );
            }

            return $data;
        }
    }
?>