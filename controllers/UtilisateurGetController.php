<?php
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/UtilisateurService.php');

class StatutGetController extends AbstractController {
    private $service;
    private $utilisateur;

    public function __construct($form) {
        parent::__construct($form, 'UtilisateurGetController');
        $this->service = new UtilisateurService();
    }

    protected function checkForm() {
        error_log(__FUNCTION__);
    }

    protected function checkCybersec() {
        error_log(__FUNCTION__);
    }

    protected function checkRights() {
        error_log(__FUNCTION__);
    }

    public function processRequest() {
        try {
            $this->utilisateur = $this->service->fetchAll();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error fetching utilisateurs: ' . $e->getMessage()]);
            exit();
        }
    }

    public function processResponse() {
        echo json_encode($this->utilisateur);
    }
}

$form = $_GET;
$controller = new StatutGetController($form);
$controller->processRequest();
$controller->processResponse();
?>
