<?php
    require_once "baseModel.php";

    class Comment extends BaseModel {
        private $conn;
        private $account;
        function __construct($conn) {
            $this->conn = $conn;
            
            require_once "accounts.php";
            $this->account = New Account;
        }

        function createNewComment($statement_id, $comment, $username) {
            $userid = $this->account->findUser($this->conn, $username);

            $stmt = $this->conn->prepare("INSERT INTO comments (statement_id, author_id, text)
            VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $statement_id, $userid, $comment);
            
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
                $username = $this->account->findUserById($this->conn, $row["author_id"]);
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
                $username = $this->account->findUserById($this->conn, $row["author_id"]);
                array_push($data, array(
                    $row["id"],
                    $row["statement_id"],
                    $username,
                    $row["text"]
                ));
            }

            return $data;
        }
    }
?>