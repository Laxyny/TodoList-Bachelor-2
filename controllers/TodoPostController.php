<?php
define('ROOT', dirname(__DIR__)); // Définir la constante ROOT pour qu'elle pointe vers le répertoire racine

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/TodoService.php');

class TodoPostController extends AbstractController {
    private $service;
    private $response;

    public function __construct($form) {
        parent::__construct($form, 'TodoPostController');
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
        $title = $this->form['title'] ?? '';
        $description = $this->form['description'] ?? '';
        $dueDate = $this->form['dueDate'] ?? '';
        $userId = $this->form['userId'] ?? '';

        if (empty($title) || empty($description) || empty($dueDate) || empty($userId)) {
            $this->response = ['success' => false, 'error' => 'All fields are required'];
            return;
        }

        $todo = new Todo(
            null,
            $title,
            $description,
            date('Y-m-d'), // date_creation
            $dueDate,
            1, // id_statut (par exemple, 1 pour "à faire")
            1, // id_priorite (par exemple, 1 pour "normal")
            $userId
        );

        try {
            $this->service->insert($todo);
            $this->response = ['success' => true];
        } catch (Exception $e) {
            $this->response = ['success' => false, 'error' => 'Error adding todo: ' . $e->getMessage()];
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
        $controller = new TodoPostController($form);
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
