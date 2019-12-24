<?php

class HierarchieManager
{

    private $conn;

    function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getChild($ingredient) : array {

        $ingredient = $this->conn->real_escape_string($ingredient);

        $sql = "SELECT sous_categorie
                FROM hierarchie
                WHERE categorie = '$ingredient';";

        $result = $this->conn->query($sql);

        $array = array();
        while ($row = $result->fetch_row()) {
            array_push($array, $row[0]);
        }

        return $array;

    }

    public function getAllChilds($ingredient) : array {
        $array = array();

        $this->RgetAllChilds($ingredient, $array);

        return $array;
    }

    private function RgetAllChilds(string $ingredient, array &$array) {
        foreach ($this->getChild($ingredient) as $child) {
            array_push($array, $child);
            $this->RgetAllChilds($child, $array);
        }
    }

    public function getSuper(string $ingredient) : string {

        $ingredient = $this->conn->real_escape_string($ingredient);

        $sql = "SELECT categorie
                FROM hierarchie
                WHERE sous_categorie = '$ingredient';";

        if($result = $this->conn->query($sql)) {
            if ($result->num_rows > 0) {
                return $result->fetch_row()[0];
            }
        }

        return "";
    }

    public function getPath(string $ingrdient) : array {
        $array = array();
        $this->RgetPath($ingrdient, $array);
        array_reverse($array);
        return $array;
    }

    private function RgetPath(string $ingredient, array &$array) {
        $super = $this->getSuper($ingredient);
        if ($super != "") {
            array_push($array, $super);
            $this->RgetPath($super, $array);
        }
    }

    public function f($source) {
        echo "<ul>";
        foreach ($this->getChild($source) as $ingredient) {
            echo "<li>$ingredient</li>";
            $this->f($ingredient);
        }
        echo "</ul>";
    }

}