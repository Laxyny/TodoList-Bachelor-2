<?php
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/AdminService.php');

class AdminController extends AbstractController {
    private $service;
    private $response;

    public function __construct($form) {
        parent::__construct($form, 'AdminController');
        $this->service = new AdminService();
    }

    protected function checkForm() {
        // Vérification des données du formulaire si nécessaire
    }

    protected function checkCybersec() {
        // Vérification de la sécurité si nécessaire
    }

    protected function checkRights() {
        // Vérification des droits d'accès si nécessaire
    }

    public function processRequest() {
        $action = $this->form['action'] ?? '';
        switch ($action) {
            case 'list_users':
                $this->response = $this->service->listUsers();
                break;
            case 'create_user':
                $this->response = $this->service->createUser($this->form);
                break;
            case 'delete_user':
                $this->response = $this->service->deleteUser($this->form['id']);
                break;
            case 'list_statuses':
                $this->response = $this->service->listStatuses();
                break;
            case 'create_status':
                $this->response = $this->service->createStatus($this->form);
                break;
            case 'delete_status':
                $this->response = $this->service->deleteStatus($this->form['id']);
                break;
            default:
                $this->response = ['success' => false, 'error' => 'Invalid action'];
        }
    }

    public function processResponse() {
        header('Content-Type: application/json');
        echo json_encode($this->response);
    }
}

try {
    $controller = new AdminController($_POST);
    $controller->processRequest();
    $controller->processResponse();
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Internal server error: ' . $e->getMessage()]);
}
?>
