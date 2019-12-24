<?php

include_once "models/PanierManager.php";
include_once "models/DrinkManager.php";
    session_start();
    $id = "";

    if (isset($_SESSION["user"])) {
        $id = $_SESSION["user"];
    }

$servername = "jawtoch.ddns.net";
$username = "guest";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title> Panier </title>
</head>
<body class="container-full">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/index.php"> Accueil </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/hierarchie.php"> Hierarchie </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/panier.php"> Panier </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/compte.php"> Compte </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/recherche.php"> Recherche </a>
            </li>
        </ul>
    </div>
</nav>
<br>
<div class="container-fluid">

    <p class="h2"> Recettes favorites </p>

    <?php
        if ($id == "") {
            echo "<p> Pas de recettes dans vos favoris </p>";
        } else {
            $panier = new PanierManager($conn, $id);
            $drinkManager = new DrinkManager($conn);
            echo "<div class='list-group'>";
            foreach ($panier->getFavorites() as $favorite) {
                $recette = $drinkManager->getRecetteById($favorite);
                echo "<a class='list-group-item list-group-item-action' href='view.php?id=$favorite'>" . $recette->getTitle() . "</a>";
            }
            echo "</div>";
        }

    ?>


</div>
<br>
</body>
</html>

<?php
$conn->close();
?>