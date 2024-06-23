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

    public function fetchDeletedTodos() {
        return $this->todoDao->fetchDeletedTodos();
    }

    public function fetchAllByUser($id) {
        return $this->todoDao->fetchAllByUser($id);
    }

    public function create($data) {
        error_log('Create Todo data: ' . print_r($data, true));
    
        $titre = $data['titre'] ?? '';
        $description = $data['description'] ?? '';
        $date_creation = $data['date_creation'] ?? '';
        $date_echeance = $data['date_echeance'] ?? '';
        $id_statut = $data['id_statut'] ?? 1; // Par défaut, le statut est créé
        $id_priorite = $data['id_priorite'] ?? 1; // Par défaut, la priorité est normale
        $id_utilisateur = $data['id_utilisateur'] ?? '';
    
        if (empty($titre) || empty($description) || empty($date_echeance) || empty($id_utilisateur) || empty($date_creation)) {
            return ['success' => false, 'error' => 'All fields are required'];
        }
    
        return $this->todoDao->insert($titre, $description, $date_creation, $date_echeance, $id_statut, $id_priorite, $id_utilisateur);
    }

    public function insert($entity) {
        //return $this->todoDao->insert($entity);
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