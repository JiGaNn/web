<?php
require_once "BaseSpaceTwigController.php";

class MainController extends BaseSpaceTwigController {
    public $template = "main.twig";
    public $title = "Main";
    public function getContext(): array
    {
        $context = parent::getContext();
        
        if (isset($_GET['type'])) {
            $query = $this->pdo->prepare("SELECT * FROM amazing_animals WHERE type = :type");
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        } else {
            $query = $this->pdo->query("SELECT * FROM amazing_animals");
        }
        
        $context['animals'] = $query->fetchAll();

        return $context;
    }
}