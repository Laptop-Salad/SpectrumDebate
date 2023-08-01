<?php
    require_once "baseModel.php";

    class Comment extends BaseModel {
        private $account;
        function __construct() {            
            require_once "accounts.php";
            $this->account = New Account;
            $this->connectDB();
        }

        function createComment($statementId, $comment, $username) {
            /**
             * @param int $statementId
             * @param string $comment
             * @param string $username
             */
            $userid = $this->account->findUser($username);

            $stmt = $this->conn->prepare("INSERT INTO comments (statement_id, author_id, text)
            VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $statementId, $userid, $comment);
            
            if($stmt->execute()) {
                return True;
            }

            return False;
        }

        function updateComment($commentId, $text) {
            /**
             * @param string $commentId
             * @param string $text
             */
            $stmt = $this->conn->prepare("UPDATE comments SET text = ?
            WHERE id = ?");
            $stmt->bind_param("ss", $text, $commentId);
            
            if($stmt->execute()) {
                return True;
            }

            return False;
        }

        function deleteComment($commentId) {
            /**
             * @param string $commentId
             */
            $stmt = $this->conn->prepare("DELETE FROM comments WHERE id = ?");
            $stmt->bind_param("s", $commentId);
            
            if($stmt->execute()) {
                return True;
            }

            return False;
        }

        function getStatementComments($statementId) {
            /**
             * @param string $statementId
             */
            $stmt = $this->conn->prepare("SELECT * FROM comments WHERE statement_id = ?");
            $stmt->bind_param("s", $statementId);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = array();

            while ($row = $result->fetch_assoc()) {
                $username = $this->account->findUserById($row["author_id"]);
                array_push($data, array(
                    "id" => $row["id"],
                    "statement_id" => $row["statement_id"],
                    "username" => $username,
                    "text" => $row["text"]
                ));
            }

            return $data;
        }

        function getUserComments($userId) {
            /**
             * @param string $userId
             */
            $stmt = $this->conn->prepare("SELECT * FROM comments WHERE author_id = ?");
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = array();

            while ($row = $result->fetch_assoc()) {
                $username = $this->account->findUserById($row["author_id"]);
                array_push($data, array(
                    "id" => $row["id"],
                    "statement_id" => $row["statement_id"],
                    "username" => $username,
                    "text" => $row["text"]
                ));
            }

            return $data;
        }

        function getCommentById($commentId) {
            /**
             * @param string $commentId
             */
            $stmt = $this->conn->prepare("SELECT * FROM comments WHERE id = ?");
            $stmt->bind_param("s", $commentId);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = array();

            while ($row = $result->fetch_assoc()) {
                $username = $this->account->findUserById($row["author_id"]);
                $data = array(
                    "id" => $row["id"],
                    "statement_id" => $row["statement_id"],
                    "username" => $username,
                    "text" => $row["text"]
                );
            }

            return $data;
        }
    }
?>