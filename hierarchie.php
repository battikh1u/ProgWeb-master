<?php
include_once "models/HierarchieManager.php";
include_once "models/DrinkManager.php";

$servername = "jawtoch.ddns.net";
$username = "guest";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

$hierarchieManager = new HierarchieManager($conn);

if (isset($_POST["source"])) {
    $source = $_POST["source"];
} else {
    $source = "Aliment";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <title> Hierarchie </title>
    </head>
    <body class="container-full">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/index.php"> Accueil </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
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
                Hierarchie
            </p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php
                    foreach ($hierarchieManager->getPath($source) as $super) {
                        echo "<li class='breadcrumb-item'> $super </li>";
                    }
                    echo "<li class='breadcrumb-item'> $source </li>";
                    ?>
                </ol>
            </nav>

            <ul class="nav nav-pills nav-fill">
                <?php
                $childs = $hierarchieManager->getChild($source);
                foreach ($childs as $child) {
                    echo "
                    <li class='nav-item'>
                        <form method='post' action='./hierarchie.php'>
                            <button type='submit' class='btn btn-primary' name='source' value='$child'> $child </button>
                        </form>
                    </li>";
                }
                ?>
            </ul>

            <div id='list' class='card-columns'>
                <?php
                    $ingredients = $hierarchieManager->getAllChilds($source);
                    array_push($ingredients, $source);
                    $drinkManager = new DrinkManager($conn);
                    $recettes = $drinkManager->recetteWith($ingredients);
                    foreach ($recettes as $recette) {
                        echo $recette->cardView();
                    }
                ?>
            </div>
        </div>
        <br>
    </body>
</html>

<?php
$conn->close();
?>