<?php
require_once(ROOT . '/utils/AbstractService.php');
require_once(ROOT . '/utils/BaseService.php');
require_once(ROOT . '/dao/TodoDao.php');

class TodoService extends AbstractService implements BaseService {
    private $todoDao;

    public function __construct() {
        $this->todoDao = new TodoDao(DbSingleton::getInstance()->getConnection());
    }

    public function fetchAll() {
        return $this->todoDao->fetchAll();
    }

    public function fetch($id) {
        // Implémentation si nécessaire
    }

    public function insert($entity) {
        // Implémentation si nécessaire
    }

    public function update($entity) {
        // Implémentation si nécessaire
    }

    public function delete($id) {
        // Implémentation si nécessaire
    }
}
?>
