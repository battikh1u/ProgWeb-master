<?php
include "ressources/Donnees.inc.php";
include_once "models/importer/IngredientsImporter.php";
include_once "models/importer/RecetteImporter.php";

global $re;
$re = $Recettes;

global $hierarchie;
$hierarchie = $Hierarchie;

$servername = "jawtoch.ddns.net";
$username = "guest";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur lors de la connexion à la db: " . $conn->connect_error);
}

$ingredientImporter = new IngredientsImporter($conn, $hierarchie);

$ingredientImporter->import();

$recetteImporter = new RecetteImporter($conn, $re);

$recetteImporter->import();

$conn->close();

?>