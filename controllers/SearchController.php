<?php
require_once "BaseAnimalTwigController.php";

class SearchController extends BaseAnimalTwigController
{
    public $template = "search.twig";

    public function getContext(): array
    {
        $context = parent::getContext();

        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $description = isset($_GET['description']) ? $_GET['description'] : '';

        $sql = <<<EOL
SELECT id, title
FROM amazing_animals
WHERE (:title = '' OR title like CONCAT('%', :title, '%'))
    AND (:description = '' OR description like CONCAT('%', :description, '%'))
    AND (:type = 'Все' OR type = :type)
EOL;

        $query = $this->pdo->prepare($sql);

        $query->bindValue("description", $description);
        $query->bindValue("title", $title);
        $query->bindValue("type", $type);
        $query->execute();

        $context['animals'] = $query->fetchAll();

        return $context;
    }
}
