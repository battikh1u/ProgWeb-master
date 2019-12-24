<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script   src="https://code.jquery.com/jquery-3.4.1.min.js"   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="   crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <title> Recherche </title>
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
            <li class="nav-item active">
                <a class="nav-link" href="/recherche.php"> Recherche </a>
            </li>
        </ul>
    </div>
</nav>
<br>
<div class="container-fluid">
    <div>
        <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">@</div>
            </div>
            <input type="text" class="form-control" placeholder="Ingredient" onchange="e(this.value)">
        </div>
    </div>

    <div class="list-group" id="ingredients">
    </div>

    <div class='card-columns' id="recettesList">
    </div>

</div>
</body>
</html>

<script type="application/javascript">
    function e(v) {
        $.ajax({
            type: "GET",
            url: "http://jawtoch.ddns.net/api/ingredients/ingredient.php",
            data: "name=" + v,
            success: function (d) {
                succes(d);
            }
        });
    }

    function succes(v) {
        var ingredientsList = document.getElementById('ingredients');
        ingredientsList.innerHTML = '';

        var json = JSON.parse(v);
        json.forEach(element => {
            var item = document.createElement("a");
            item.innerText = element;
            item.className = "list-group-item list-group-item-action";
            item.onclick = function () {
              addIngredient(element);
            };

            ingredientsList.appendChild(item);

        });
    }

    var ingredients = new Set();


    function addIngredient(ingredient) {
        if (ingredients.has(ingredient)) {
            ingredients.delete(ingredient)
        } else {
            ingredients.add(ingredient);
        }
        console.log(ingredients);
        reloadRecettes();
    }

    function reloadRecettes() {
        var arr = Array.from(ingredients);
        var jsonString = JSON.stringify(arr);

        $.ajax({
            type: "POST",
            url: "http://jawtoch.ddns.net/api/recettes/recettes.php",
            data: {
                ingredients: jsonString
            },
            success: function (d) {
                var recettesList = document.getElementById('recettesList');
                recettesList.innerHTML = d;
            }
        });
    }
</script>