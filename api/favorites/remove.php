<?php

include_once "../../models/PanierManager.php";

$servername = "jawtoch.ddns.net";
$username = "guest";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

session_start();

if (isset($_SESSION["user"])) {
    $userID = $_SESSION["user"];
} else {
    die("User ID missing");
}

if (isset($_POST["recetteID"])) {
    $recetteID = $_POST["recetteID"];
} else {
    die("Recette ID missing");
}
$panier = new PanierManager($conn, $userID);
$panier->removeFavorite($recetteID);
$conn->close();

header("Location: http://jawtoch.ddns.net/panier.php");