<?php

include_once "../../models/DrinkManager.php";

if (isset($_POST['ingredients'])) {
    $data = json_decode(stripslashes($_POST['ingredients']));
    $ingredients = $data;
} else {
    die();
}

$servername = "jawtoch.ddns.net";
$username = "guest";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

$drinks = new DrinkManager($conn);
$recettes = $drinks->recetteWith($ingredients);
foreach ($recettes as $recette) {
    echo $recette->cardView();
}

$conn->close();