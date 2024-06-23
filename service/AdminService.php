<?php
require_once(ROOT . '/utils/AbstractService.php');
require_once(ROOT . '/utils/BaseService.php');
require_once(ROOT . '/dao/UtilisateurDao.php');
require_once(ROOT . '/dao/StatutDao.php');
require_once(ROOT . '/utils/DbSingleton.php');

class AdminService extends AbstractService implements BaseService {
    private $utilisateurDao;
    private $statutDao;

    public function __construct() {
        $this->utilisateurDao = new UtilisateurDao(DbSingleton::getInstance()->getConnection());
        $this->statutDao = new StatutDao(DbSingleton::getInstance()->getConnection());
    }

    public function fetchAll() {
        // Implémentation si nécessaire
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

    public function listUsers() {
        return $this->utilisateurDao->fetchAll();
    }

    public function createUser($data) {
        $utilisateur = $data['utilisateur'] ?? '';
        $password = $data['password'] ?? '';
        $role = $data['role'] ?? 'user';

        if (empty($utilisateur) || empty($password)) {
            return ['success' => false, 'error' => 'Utilisateur and password are required'];
        }

        return $this->utilisateurDao->register($utilisateur, $password, $role);
    }

    public function deleteUser($id) {
        return $this->utilisateurDao->delete($id);
    }

    public function listStatuses() {
        return $this->statutDao->fetchAll();
    }

    public function createStatus($data) {
        $name = $data['name'] ?? '';
        if (empty($name)) {
            return ['success' => false, 'error' => 'Status name is required'];
        }
        return $this->statutDao->create($name);
    }

    public function deleteStatus($id) {
        return $this->statutDao->delete($id);
    }
}
?>
