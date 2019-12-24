<?php
    include "models/DrinkManager.php";
    include "models/HierarchieManager.php";

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
    <title> Accueil </title>
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
        <?php $drinkManager = new DrinkManager($conn);
        echo $drinkManager->cardsView();?>
    </div>
    <br>
</body>
</html>

<?php
$conn->close();
?>