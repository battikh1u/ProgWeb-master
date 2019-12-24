<?php

session_start();

if (isset($_SESSION['user'])) {
    $id = $_SESSION['user'];
} else {
    $id = "";
}
?>

<!DOCTYPE html>
 <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <title> Compte </title>
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

        <?php
            if ($id != "") {
                echo "<p class='h2'> Utilisateur connecté </p>";
                echo "<button onclick='window.location.href = \"http://jawtoch.ddns.net/api/account/logout.php\"' class='btn btn-primary'> Se déconnecter </button>";
            }
        ?>

        <form method="post" action="api/account/login.php">
            <p class="h2"> Se connecter </p>
            <div class="form-group">
                <label for="loginMailInput">Email</label>
                <input type="email" class="form-control" id="loginMailInput" aria-describedby="loginEmailHelp" name="mail">
                <small id="loginEmailHelp" class="form-text text-muted">Votre mail sert d'identifiant</small>
            </div>
            <div class="form-group">
                <label for="loginPasswordInput">Mot de passe</label>
                <input type="password" class="form-control" id="loginPasswordInput" name="password">
            </div>
            <button type="submit" class="btn btn-primary"> Se connecter </button>
        </form>
        <br>

        <form method="post" action="api/account/create.php">
            <p class="h2"> S'inscrire </p>
            <div class="form-group">
                <label for="mailInput">identifiant</label>
                <input type="text" class="form-control" id="mailInput"  name="mail">
                <small id="emailHelp" class="form-text text-muted">Votre mail sert d'identifiant</small>
            </div>
            <div class="form-group">
                <label for="passwordInput">Mot de passe</label>
                <input type="password" class="form-control" id="passwordInput" name="password">
            </div>
            <button type="submit" class="btn btn-primary"> S'inscrire </button>
        </form>

    </div>
    <br>
    </body>
 </html>