<?php
    include_once "models/DrinkManager.php";
    include_once "models/PanierManager.php";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        die("Aucun ID de recette");
    }


$servername = "jawtoch.ddns.net";
$username = "guest";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

$drinkManager = new DrinkManager($conn);
$recette = $drinkManager->getRecetteById($id);

session_start();
$userID = "";

if (isset($_SESSION["user"])) {
    $userID = $_SESSION["user"];
}

$panier = new PanierManager($conn, $userID);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title> View </title>
</head>
<body class="container-full">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/index.php"> Accueil </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/hierarchie.php"> Hierarchie </a>
            </li>
            <li class="nav-item">
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
        <p class="h1">
            <?php echo $recette->getTitle(); ?>
        </p>
        <p class="h3"> Ingrdients </p>
            <?php
                $ingredients = explode("|", $recette->getIngredientsInstruction());
                echo "<ul>";

                foreach ($ingredients as $ingredient) {
                    echo "<li> $ingredient </li>";
                }

                echo "</ul>";
            ?>
        <p class="h3"> Recette</p>
        <?php echo $recette->getPreparation(); ?>
        <br><br>
        <?php
            if ($userID != "") {
                $recetteFavorites = $panier->getFavorites();
                if (in_array($id, $recetteFavorites)) {
                    echo "<form method='post' action='api/favorites/remove.php'><button type='submit' class='btn btn-primary' name='recetteID' value=" . $recette->getID() . "> Supprimer des favoris </button></form>";
                } else {
                    echo "<form method='post' action='api/favorites/add.php'><button type='submit' class='btn btn-primary' name='recetteID' value=" . $recette->getID() . "> Ajouter aux favoris </button></form>";
                }
            } else {
                echo "<p class='small'> Veuillez vous connecter pour ajouter / supprimer cette recette à vos favoris </p>";
            }

        ?>
    </div>
    <br>
</body>
</html>