<?php
require_once "BaseSpaceTwigController.php";

class MainController extends BaseSpaceTwigController {
    public $template = "main.twig";
    public $title = "Main";
    public function getContext(): array
    {
        $context = parent::getContext();
        
        if (isset($_GET['type'])) {
            $query = $this->pdo->prepare("SELECT * FROM space_objects WHERE type = :type");
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        } else {
            $query = $this->pdo->query("SELECT * FROM space_objects");
        }
        
        $context['space_objects'] = $query->fetchAll();

        return $context;
    }
}