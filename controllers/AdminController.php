<?php
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/AdminService.php');
require(ROOT . '/service/UtilisateurService.php');

class AdminController extends AbstractController {
    private $utilisateurService;
    private $service;
    private $response;

    public function __construct($form) {
        parent::__construct($form, 'AdminController');
        $this->utilisateurService = new UtilisateurService();
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
                $this->listUsers();
                break;
            case 'create_user':
                $this->response = $this->service->createUser($this->form);
                break;
            case 'delete_user':
                //$this->response = $this->service->deleteUser($this->form['id']);
                break;
            case 'list_statuses':
                //$this->response = $this->service->listStatuses();
                break;
            case 'create_status':
                //$this->response = $this->service->createStatus($this->form);
                break;
            case 'delete_status':
                //$this->response = $this->service->deleteStatus($this->form['id']);
                break;
            default:
                $this->response = ['success' => false, 'error' => 'Invalid action'];
        }
    }

    private function listUsers() {
        try {
            $users = $this->service->fetchAll();
            $this->response = $users;
        } catch (Exception $e) {
            $this->response = ['success' => false, 'error' => 'Error fetching users: ' . $e->getMessage()];
        }
    }

    public function processResponse() {
        header('Content-Type: application/json');
        echo json_encode($this->response);
    }
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $form = json_decode(file_get_contents('php://input'), true);
        error_log("Form data: " . print_r($form, true));
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON input: ' . json_last_error_msg());
        }
        $controller = new AdminController($form);
        $controller->processRequest();
        $controller->processResponse();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Internal server error: ' . $e->getMessage()]);
}
?>
