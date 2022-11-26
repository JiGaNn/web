<?php

class ObjectController extends TwigBaseController
{
    public $template = "__object.twig"; // указываем шаблон

    public function getContext(): array
    {
        $context = parent::getContext();

        // создам запрос, под параметр создаем переменную my_id в запросе
        $query = $this->pdo->prepare("SELECT description, image, info, id FROM space_objects WHERE id= :my_id");
        // подвязываем значение в my_id 
        $query->bindValue("my_id", $this->params['id']);
        $query->execute(); // выполняем запрос
        // стягиваем одну строчку из базы
        $data = $query->fetch();

        // передаем описание из БД в контекст
        $context['description'] = $data['description'];
        $context['id'] = $data['id'];
        $context['image'] = $data['image'];
        $context['info'] = nl2br($data['info']);

        return $context;
    }
}
