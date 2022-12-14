<?php
require_once "BaseAnimalTwigController.php";

class ObjectController extends BaseAnimalTwigController
{
    public $template = "__object.twig";

    public function getContext(): array
    {
        $context = parent::getContext();

        $query = $this->pdo->prepare("SELECT description, image, info, id FROM amazing_animals WHERE id= :my_id");
        $query->bindValue("my_id", $this->params['id']);
        $query->execute();
        $data = $query->fetch();

        $context['description'] = $data['description'];
        $context['id'] = $data['id'];
        $context['image'] = $data['image'];
        $context['info'] = nl2br($data['info']);

        return $context;
    }
    public function get($context) {
        if (isset($_GET['show'])) {
            $this->template = "{$_GET['show']}.twig";
        }
        parent::get($context);
    }
}
