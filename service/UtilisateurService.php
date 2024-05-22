<?php
require_once(ROOT . '/utils/AbstractService.php');
require_once(ROOT . '/utils/BaseService.php');
require_once(ROOT . '/dao/UtilisateurDao.php');
require_once(ROOT . '/utils/DbSingleton.php'); // Ajout de l'inclusion de DbSingleton

class UtilisateurService extends AbstractService implements BaseService {
    private $utilisateurDao;

    public function __construct() {
        $this->utilisateurDao = new UtilisateurDao(DbSingleton::getInstance()->getConnection());
    }

    public function fetchAll() {
        return $this->utilisateurDao->fetchAll();
    }

    public function fetch($id) {
        return $this->utilisateurDao->fetch($id);
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

    public function login($email, $password) {
        return $this->utilisateurDao->login($email, $password);
    }
}
?>