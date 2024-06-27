<?php
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/UtilisateurService.php');

session_start();

class RegisterController extends AbstractController {
    private $service;
    private $response;

    public function __construct($form) {
        parent::__construct($form, 'RegisterController');
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
        if (empty($utilisateur) || empty($password)) {
            $this->response = ['success' => false, 'error' => 'L\'utilisateur et le mot de passe est requis'];
            return;
        }

        if ($this->service->register($utilisateur, $password)) {
            $this->response = ['success' => true];
        } else {
            $this->response = ['success' => false, 'error' => 'Registration failed'];
        }
    }

    public function processResponse() {
        header('Content-Type: application/json');
        echo json_encode($this->response);
    }
}

try {
    $form = json_decode(file_get_contents('php://input'), true);
    $controller = new RegisterController($form);
    $controller->processRequest();
    $controller->processResponse();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Internal server error: ' . $e->getMessage()]);
}
?>
