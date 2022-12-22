<?php
require_once "BaseAnimalTwigController.php";

class AnimalObjectUpdateController extends BaseAnimalTwigController {
    public $template = "animal_object_update.twig";

    public function get(array $context) 
    {
        $id = $this->params['id'];

        $sql = <<<EOL
SELECT * FROM amazing_animals WHERE id = :id
EOL;
        $query = $this->pdo->prepare($sql);
        $query = $this->pdo->prepare("SELECT * FROM amazing_animals WHERE id = :id");
        $query->bindValue("id", $id);
        $query->execute();

        $data = $query->fetch();
        $context['object'] = $data;
        parent::get($context);
    }

    public function post(array $context)
    {   
        $id = $_POST['id'] ?? "";
        $type = $_POST['type'] ?? "";
        $description = $_POST['description'] ?? "";
        $title = $_POST['title'] ?? "";
        $info = $_POST['info'] ?? "";
        $tmp_name = $_FILES['image']['tmp_name'] ?? "";
        $name =  $_FILES['image']['name'] ?? "";
        if ($name!="")
        {
            move_uploaded_file($tmp_name, "../public/media/$name");
            $image_url = "/media/$name";
        }
        else
        {
            $image_url = $_POST['image-bag'] ?? "";
        }
        $sql = <<<EOL
UPDATE amazing_animals SET title = :title, image = :image_url, description = :description, type = :type, info = :info WHERE id = :id
EOL;
        $query = $this->pdo->prepare($sql);
        $query->bindValue("id", $id);
        $query->bindValue("title", $title);
        $query->bindValue("description", $description);
        $query->bindValue("type", $type);
        $query->bindValue("info", $info);
        $query->bindValue("image_url", $image_url);
        $query->execute();

        $context['message'] = 'Вы успешно изменили объект';
        $this->get($context);
    }
}