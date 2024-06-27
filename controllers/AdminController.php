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
            case 'list_status':
                $this->listAllStatus();
                break;
            case 'list_categories':
                $this->listAllCategories();
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

    private function listAllStatus() {
        try {
            $status = $this->service->listStatus();
            $this->response = $status;
        } catch (Exception $e) {
            $this->response = ['success' => false, 'error' => 'Error fetching status: ' . $e->getMessage()];
        }
    }

    private function listAllCategories() {
        try {
            $categories = $this->service->listCategories();
            $this->response = $categories;
        } catch (Exception $e) {
            $this->response = ['success' => false, 'error' => 'Error fetching categories: ' . $e->getMessage()];
        }
    }

    public function processResponse() {
        header('Content-Type: application/json');
        $jsonResponse = json_encode($this->response);
        echo $jsonResponse;
    }
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $form = json_decode(file_get_contents('php://input'), true);
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
