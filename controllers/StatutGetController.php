<?php
define('ROOT', dirname(__DIR__));

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

    public function processRequest() {
        try {
            $this->statuts = $this->service->fetchAll();
            error_log('Statuts fetched: ' . print_r($this->statuts, true));
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error fetching statuts: ' . $e->getMessage()]);
            exit();
        }
    }

    public function processResponse() {
        echo json_encode($this->statuts);
    }
}

$form = $_GET;
$controller = new StatutGetController($form);
$controller->processRequest();
$controller->processResponse();
?>
