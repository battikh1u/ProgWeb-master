<?php

include_once "Importer.php";

class RecetteImporter implements Importer {

    private $conn;
    private $data;

    function import() {
        $this->createTable();
        foreach ($this->data as $recette) {

            $id = $this->uuid();
            $title = $this->conn->real_escape_string($recette["titre"]);
            $ingredients = $this->conn->real_escape_string($recette["ingredients"]);
            $preparation = $this->conn->real_escape_string($recette["preparation"]);

            $sql = "INSERT INTO recette (id, titre, preparation, ingredients) VALUES ('$id', '$title', '$preparation', '$ingredients')";

            if ($this->conn->query($sql) == false) {
                die("Impossible d'ajouter la recette " . $title . ": " . $this->conn->error);
            }

            foreach ($recette["index"] as $ingredient) {

                $ingredient = $this->conn->real_escape_string($ingredient);

                $sql = "INSERT IGNORE INTO ingredients (recette_id, ingredient) VALUES ('$id','$ingredient')";

                if ($this->conn->query($sql) == false) {
                    die("Impossible d'ajouter l'ingredient " . $ingredient . " à la recette " . $title . " : " . $this->conn->error);
                }
            }
        }

    }

    function createTable() {
        if (!$this->tableExist()) {
            $sql = "CREATE TABLE recette (
                id VARCHAR(36) NOT NULL,
                titre TEXT NOT NULL,
                ingredients TEXT NOT NULL,
                preparation TEXT NOT NULL,
                PRIMARY KEY (id));";

            if ($this->conn->query($sql) == false) {
                die("Impossible de créer la table recette");
            }

            $sql = "CREATE TABLE ingredients (
                    recette_id VARCHAR(36) NOT NULL,
                    ingredient VARCHAR(128) NOT NULL,
                    PRIMARY KEY (recette_id, ingredient),
                    FOREIGN KEY (recette_id) REFERENCES recette (id));";

            if ($this->conn->query($sql) == false) {
                die("Impossible de créer la table ingredients");
            }
        }
    }

    function uuid(): string {
        $sql = "SELECT UUID();";
        $result = $this->conn->query($sql);
        return $result->fetch_row()[0];

    }

    private function tableExist(): bool {
        $sql = "SELECT 1 FROM recette LIMIT 1;";

        return $this->conn->query($sql) == true;
    }

    public function __construct(mysqli $conn, array $data) {
        $this->conn = $conn;
        $this->data = $data;
    }
}