<?php

include_once "../../models/UserManager.php";

$servername = "jawtoch.ddns.net";
$username = "guest";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur lors de la connexion à la db: " . $conn->connect_error);
}

$userManager = new UserManager($conn);

$userManager->disconnect();

$conn->close();

header("Location: http://jawtoch.ddns.net");