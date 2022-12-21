<?php
require_once "BaseAnimalTwigController.php";

class AnimalTypeCreateController extends BaseAnimalTwigController {
    public $template = "animal_type_create.twig";

    public function get(array $context)
    {   
        parent::get($context);
    }

    public function post(array $context) {
        $title = $_POST['title'];

        $tmp_name = $_FILES['image']['tmp_name'];
        $name =  $_FILES['image']['name'];
        move_uploaded_file($tmp_name, "../public/media/$name");
        $image_url = "/media/$name";

        $sql = <<<EOL
INSERT INTO animal_types(title, image)
VALUES(:title, :image_url)
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("title", $title);
        $query->bindValue("image_url", $image_url);
        $query->execute();
        
        $context['title'] = $title;
        $context['message'] = 'Вы успешно создали тип';
        $context['id'] = $this->pdo->lastInsertId();

        $this->get($context);
    }
}