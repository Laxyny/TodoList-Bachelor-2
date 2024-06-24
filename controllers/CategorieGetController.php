<?php
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/CategorieService.php');

class CategorieGetController extends AbstractController {
    private $service;
    private $statuts;

    public function __construct($form) {
        parent::__construct($form, 'CategorieGetController');
        $this->service = new CategorieService();
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
            $this->statuts = $this->service->fetchAll();
            error_log('Categories fetched: ' . print_r($this->statuts, true)); // Log the fetched statuts
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error fetching categories: ' . $e->getMessage()]);
            exit();
        }
    }

    public function processResponse() { // Changer en public
        echo json_encode($this->statuts);
    }
}

$form = $_GET; // Ou $_POST selon la méthode de votre formulaire
$controller = new CategorieGetController($form);
$controller->processRequest();
$controller->processResponse();
?>
