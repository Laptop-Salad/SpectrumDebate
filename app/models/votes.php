<?php
    require_once "baseModel.php";
    class Vote extends BaseModel {    
        private $account;

        function __construct()
        {
            $this->connectDB();
            require_once "accounts.php";
            $account = new Account;
            $this->account = $account;
        }

        function createVote($username, $statement_id, $vote) {
            /**
             *  Creates a new vote.
             * 
             * @param string $username
             * @param string $statement_id
             * @param string $vote
             * @return bool
             */
            $userid = $this->account->findUser($username);

            $stmt = $this->conn->prepare("INSERT INTO votes (statement_id, opinion, author_id)
            VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $statement_id, $vote, $userid);

            if ($stmt->execute()) {
                return True;
            }

            return False;
        }

        function getStatementVotesCount($statement_id) {
            /**
             * Gets the statistics of a statement's votes. This includes:
             * - disagree
             * - neutral
             * - agree
             * - total
             * 
             * @param string $statement_id
             * @return array associative array
             */
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

        function findVote($statement_id, $username) {
            /**
             * finds a vote
             * @param string $statement_id
             * @param string $username
             */
            $userid = $this->account->findUser($username);

            $stmt = $this->conn->prepare("SELECT * FROM votes WHERE statement_id = ? and author_id = ?");
            $stmt->bind_param("ss", $statement_id, $userid);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = array();

            while ($row = $result->fetch_assoc()) {
                array_push($data,
                $row["id"],
                $row["statement_id"],
                $row["opinion"],
                $row["author_id"]);

                return $data;
            }

            return null;
        }

        function updateVote($voteId, $newOpinion) {
            /**
             * updates a vote
             * 
             * @param string $voteId
             * @param string $newOpinion
             */
            $stmt = $this->conn->prepare("UPDATE votes SET opinion = ? WHERE id = ?;");
            $stmt->bind_param("ss", $newOpinion, $voteId);
            
            if ($stmt->execute()) {
                return True;
            } else {
                return False;
            }
        }

        function deleteVote($voteId) {
            /**
             * deletes a vote
             * @param string $voteId
             * @return bool
             */

            if (!is_numeric($voteId)) {
                return False;
            }

            $voteId = intval($voteId);

            $stmt = $this->conn->prepare("DELETE FROM votes WHERE id = ?");
            $stmt->bind_param("i", $voteId);
            
            if ($stmt->execute()) {
                return True;
            } else {
                return False;
            }
        }
    }

?>