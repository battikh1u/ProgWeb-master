<?php

include_once "Importer.php";

class IngredientsImporter implements Importer
{

    private $conn;
    private $data;

    function import() {
        $this->createTable();
        foreach($this->data as $categorie => $hierarchie) {

            if (array_key_exists("sous-categorie", $hierarchie)) {
                foreach ($hierarchie["sous-categorie"] as $sous_categorie) {

                    $categorie = $this->conn->real_escape_string($categorie);
                    $sous_categorie = $this->conn->real_escape_string($sous_categorie);

                    $sql = "INSERT INTO hierarchie (categorie, sous_categorie) VALUES ('$categorie', '$sous_categorie')";

                    if ($this->conn->query($sql) == false) {
                        die("Impossible d'importer la categorie" . $categorie . ": " . $this->conn->error);
                    }
                }
            }
        }
    }

    function createTable() {
        if (!$this->tableExist()) {
            $sql = "CREATE TABLE hierarchie (
                categorie varchar(128) NOT NULL,
                sous_categorie varchar(128) NOT NULL,
                PRIMARY KEY (categorie,sous_categorie))";

            if ($this->conn->query($sql) == false) {
                die("Impossible de créer la table hierarchie");
            }
        }
    }

    private function tableExist(): bool {
        $sql = "SELECT 1 FROM hierarchie LIMIT 1;";

        return $this->conn->query($sql);
    }

    public function __construct(mysqli $conn, array $data) {
        $this->conn = $conn;
        $this->data = $data;
    }
}