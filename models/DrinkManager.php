<?php
    include_once "Recette.php";

class DrinkManager
{
    private $recettes = array();

    function __construct(mysqli $conn) {

        $sql = "SELECT * FROM recette";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($recette = $result->fetch_assoc()) {

                $id = $recette["id"];

                $sql = "SELECT * FROM ingredients WHERE recette_id = '$id'";
                $ingredientsResult = $conn->query($sql);

                $ingredients = array();

                while ($ingredient = $ingredientsResult->fetch_row()) {

                    array_push($ingredients, $ingredient[1]);
                }
                $this->createRecette($recette, $ingredients);
            }
        }
    }

    private function createRecette(array $recetteData, array $ingredients) {
        $id = $recetteData['id'];
        $recette = new Recette($id, $recetteData['titre'], $recetteData['preparation'], $recetteData["ingredients"], $ingredients);
        $this->recettes[$id] = $recette;
    }

    public function getRecettes() : array {
        return array_keys($this->recettes);
    }

    public function getRecetteById(string $id) : Recette {
        return $this->recettes[$id];
    }

    public function cardsView() {
        $content = "<div id='list' class='card-columns'>";
        foreach ($this->recettes as $recette) {
            $content = $content . $recette->cardView();
        }
        $content = $content . "</div>";
        return $content;
    }

    public function recetteWith(array $aliments) : array {
        $array = array();

        foreach ($this->recettes as $recette) {
            $ingredients = $recette->getIngredientsList();
            if (array_intersect($ingredients, $aliments)) {
                array_push($array, $recette);
            }
        }

        return $array;
    }
}