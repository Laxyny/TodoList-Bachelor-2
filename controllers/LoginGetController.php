<?php
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/UtilisateurService.php');

session_start();

class LoginGetController extends AbstractController {
    private $service;
    private $response;

    public function __construct($form) {
        parent::__construct($form, 'LoginGetController');
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
        $utilisateur = $this->form['utilisateur'] ?? '';
        $password = $this->form['password'] ?? '';
        error_log("Utilisateur: $utilisateur, Password: $password");
    
        if (empty($utilisateur) || empty($password)) {
            $this->response = ['success' => false, 'error' => 'L\'utilisateur et le mot de passe est requis'];
            return;
        }
    
        $user = $this->service->login($utilisateur, $password);
        if ($user) {
            $_SESSION['user_id'] = $user->id_utilisateur;
            $_SESSION['role'] = $user->role;
            $this->response = ['success' => true, 'userId' => $user->id_utilisateur, 'role' => $user->role];
        } else {
            $this->response = ['success' => false, 'error' => 'L\'utilisateur et le mot de passe est requis'];
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
        $controller = new LoginGetController($form);
        $controller->processRequest();
        $controller->processResponse();
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Internal server error: ' . $e->getMessage()]);
}
?>
