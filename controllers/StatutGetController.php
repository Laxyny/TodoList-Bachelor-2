<?php
define('ROOT', dirname(__DIR__)); // Définir la constante ROOT pour qu'elle pointe vers le répertoire racine

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/StatutService.php');

class StatutGetController extends AbstractController {
    private $service;
    private $statuts;

    public function __construct($form) {
        parent::__construct($form, 'StatutGetController');
        $this->service = new StatutService();
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

    public function processRequest() { // Changer en public
        $this->statuts = $this->service->fetchAll();
    }

    public function processResponse() { // Changer en public
        echo json_encode($this->statuts);
    }
}

$form = $_GET; // Ou $_POST selon la méthode de votre formulaire
$controller = new StatutGetController($form);
$controller->processRequest();
$controller->processResponse();
?>
