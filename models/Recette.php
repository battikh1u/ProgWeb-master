<?php


class Recette
{
    private $id;
    private $title;
    private $preparation;
    private $ingredients;
    private $ingredientsList;

    function __construct(string $id, string $title, string $preparation, string $ingredients, array $ingredientsList) {
        $this->id = $id;
        $this->title = $title;
        $this->preparation = $preparation;
        $this->ingredients = $ingredients;
        $this->ingredientsList = $ingredientsList;
    }

    function stripAccents($str) {
        return strtr($str,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    /**
     * @return string
     */
    public function getID(): string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getPreparation() : string
    {
        return $this->preparation;
    }

    /**
     * @return mixed
     */
    public function getIngredientsInstruction() : string
    {
        return $this->ingredients;
    }

    /**
     * @return mixed
     */
    public function getIngredientsList() : array
    {
        return $this->ingredientsList;
    }

    public function cardView() : string {
        $content = "
            <div class='card'>
                <div class='card-body'>
                    <h5 class='card-title'> " . $this->getTitle() . " </h5>
                    <p class='card-text'> " . $this->getPreparation() . " </p>
                    <form method='get' action='../view.php'>
                        <button type='submit' class='btn btn-primary' name='id' value='$this->id'> Voir </button>
                    </form>
                </div>
            </div>
        ";
        return $content;
    }

}