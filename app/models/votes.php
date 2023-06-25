<?php
    class Vote {    
        public $conn;

        function __construct($conn)
        {
            $this->conn = $conn;
        }

        function createVote($username, $statement_id, $vote) {
            require "accounts.php";
            $account = new Account;
            $userid = $account->findUser($this->conn, $username);

            $stmt = $this->conn->prepare("INSERT INTO votes (statement_id, opinion, author_id)
            VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $statement_id, $vote, $userid);

            if ($stmt->execute()) {
                return True;
            }

            return False;
        }

        function getStatementVotesCount($statement_id) {
            $stmt = $this->conn->prepare("SELECT * FROM votes WHERE statement_id = ?");
            $stmt->bind_param("s", $statement_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = [
                "disagree" => 0,
                "neutral" => 0,
                "agree" => 0,
                "total" => 0,
            ];

            while ($row = $result->fetch_assoc()) {
                $data[$row["opinion"]] += 1;
                $data["total"] += 1;
            }

            return $data;
        }
    }

?>