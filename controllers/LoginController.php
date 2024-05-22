<?php
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/UtilisateurService.php');

session_start();

class LoginController extends AbstractController {
    private $service;
    private $response;

    public function __construct($form) {
        parent::__construct($form, 'LoginController');
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

    public function processRequest() { // Changer en public
        $email = $this->form['email'];
        $password = $this->form['password'];
        $user = $this->service->login($email, $password);
        if ($user) {
            $_SESSION['user_id'] = $user->id_utilisateur;
            $this->response = ['success' => true];
        } else {
            $this->response = ['success' => false, 'error' => 'Invalid email or password'];
        }
    }

    public function processResponse() { // Changer en public
        echo json_encode($this->response);
    }
}

$form = $_POST; // Utilisation de $_POST pour les requêtes POST
$controller = new LoginController($form);
$controller->processRequest();
$controller->processResponse();
?>
