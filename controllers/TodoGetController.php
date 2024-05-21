<?php
define('ROOT', dirname(__DIR__)); // Définir la constante ROOT pour qu'elle pointe vers le répertoire racine

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/TodoService.php');

class TodoGetController extends AbstractController {
    private $service;
    private $todos;

    public function __construct($form) {
        parent::__construct($form, 'TodoGetController');
        $this->service = new TodoService();
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
            $this->todos = $this->service->fetchAll();
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error fetching todos: ' . $e->getMessage()]);
            exit();
        }
    }

    public function processResponse() {
        echo json_encode($this->todos);
    }
}

$form = $_GET; // Ou $_POST selon la méthode de votre formulaire
$controller = new TodoGetController($form);
$controller->processRequest();
$controller->processResponse();
?>
