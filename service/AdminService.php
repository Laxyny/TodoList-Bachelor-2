<?php
require_once(ROOT . '/utils/AbstractService.php');
require_once(ROOT . '/utils/BaseService.php');
require_once(ROOT . '/dao/UtilisateurDao.php');
require_once(ROOT . '/dao/StatutDao.php');
require_once(ROOT . '/dao/CategorieDao.php');
require_once(ROOT . '/utils/DbSingleton.php');

class AdminService extends AbstractService implements BaseService {
    private $utilisateurDao;
    private $statutDao;
    private $categorieDao;

    public function __construct() {
        $this->utilisateurDao = new UtilisateurDao(DbSingleton::getInstance()->getConnection());
        $this->statutDao = new StatutDao(DbSingleton::getInstance()->getConnection());
        $this->categorieDao = new CategorieDao(DbSingleton::getInstance()->getConnection());
    }

    public function fetchAll() {
        return $this->utilisateurDao->fetchAll();
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

    public function createUser($data) {
        $utilisateur = $data['utilisateur'] ?? '';
        $password = $data['password'] ?? '';
        $role = $data['role'] ?? 'user';
    
        if (empty($utilisateur) || empty($password)) {
            return ['success' => false, 'error' => 'Utilisateur and password are required'];
        }
    
        $result = $this->utilisateurDao->register($utilisateur, $password, $role);
        error_log('Create user result: ' . print_r($result, true));
        return $result;
    }

    public function deleteUser($id) {
        //return $this->utilisateurDao->delete($id);
    }

    public function listStatus() {
        return $this->statutDao->fetchAll();
    }

    public function listCategories() {
        return $this->categorieDao->fetchAll();
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
