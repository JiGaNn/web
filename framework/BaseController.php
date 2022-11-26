<?php
abstract class BaseController {
    public PDO $pdo;
    public array $params;

    public function setParams(array $params) {
        $this->params = $params;
    }
    
    public function setPDO(PDO $pdo) { // и сеттер для него
        $this->pdo = $pdo;
    }
    
    public function getContext(): array {
        return [];
    }

    abstract public function get();
}