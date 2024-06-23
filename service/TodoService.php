<?php
require_once(ROOT . '/utils/AbstractService.php');
require_once(ROOT . '/utils/BaseService.php');
require_once(ROOT . '/dao/TodoDao.php');
require_once(ROOT . '/utils/DbSingleton.php'); // Ajout de l'inclusion de DbSingleton

class TodoService extends AbstractService implements BaseService {
    private $todoDao;

    public function __construct() {
        $this->todoDao = new TodoDao(DbSingleton::getInstance()->getConnection());
    }

    public function fetchAll() {
        return $this->todoDao->fetchAll();
    }

    public function fetch($id) {
        return $this->todoDao->fetch($id);
    }

    public function fetchAllWithDeleted($id) {
        return $this->todoDao->fetchAllWithDeleted($id);
    }

    public function fetchAllByUser($id) {
        return $this->todoDao->fetchAllByUser($id);
    }

    public function insert($entity) {
        return $this->todoDao->insert($entity);
    }

    public function update($entity) {
        // Implémentation si nécessaire
    }

    public function delete($id) {
        return $this->todoDao->delete($id);
    }

    public function editStatus($id, $newStatus) {
        return $this->todoDao->editStatus($id, $newStatus);
    }

    public function restore($id) {
        return $this->todoDao->restore($id);
    }
}
?>