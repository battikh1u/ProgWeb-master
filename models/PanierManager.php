<?php


class PanierManager
{

    private $conn;
    private $id;

    public function __construct(mysqli $conn, string $id) {
        $this->conn = $conn;
        $this->id = $id;
    }

    public function addFavorite(string $recetteID) {
        $sql = "INSERT INTO favoris (userID, recetteID) VALUES ('$this->id', '$recetteID')";

        $this->conn->query($sql);
    }

    public function removeFavorite(string $recetteID) {
        $sql = "DELETE FROM favoris WHERE userID = '$this->id' AND recetteID = '$recetteID'";

        $this->conn->query($sql);
    }

    public function getFavorites() : array {

        $array = array();

        $sql = "SELECT recetteID FROM favoris WHERE userID = '$this->id'";

        if ($result = $this->conn->query($sql)) {
            while ($recetteID = $result->fetch_row()) {

                array_push($array, $recetteID[0]);
            }
        }

        return $array;
    }

}