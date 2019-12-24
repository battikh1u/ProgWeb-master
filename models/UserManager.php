<?php


class UserManager {

    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
        session_start();
    }

    public function create(string $mail, string $password) {

        $mail = $this->conn->real_escape_string($mail);
        $password = $this->conn->real_escape_string($password);

        $sql = "INSERT INTO users (id, mail, password) VALUES (UUID(), '$mail', '$password')";

        if($result = $this->conn->query($sql)) {
            $this->login($mail, $password);
        }
    }

    public function disconnect() {
        $_SESSION['user'] = "";
    }

    public function login(string $mail, string $password) {

        $mail = $this->conn->real_escape_string($mail);
        $password = $this->conn->real_escape_string($password);

        if ($mail == "" || $password == "") {
            echo "qz";
            return;
        }

        $sql = "SELECT id 
                FROM users 
                WHERE mail = '$mail' 
                AND password = '$password'";

        $id = "";

        if($result = $this->conn->query($sql)) {
            if ($result->num_rows > 0) {
                $id = $result->fetch_row()[0];
            }
        }

        if ($id == "") {
            echo "failure";
        } else {
            echo "succes";
        }

        $_SESSION['user'] = $id;
    }

}