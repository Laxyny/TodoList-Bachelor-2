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
        $action = $this->form['action'] ?? '';

        switch ($action) {
            case 'add_todo':
                $title = $this->form['title'] ?? '';
                $description = $this->form['description'] ?? '';
                $dueDate = $this->form['dueDate'] ?? '';
                $userId = $this->form['userId'] ?? '';
                if (empty($title) || empty($description) || empty($dueDate) || empty($userId)) {
                    $this->response = ['success' => false, 'error' => 'All fields are required'];
                    return;
                }
                $this->service->insert(new Todo(
                    null,
                    $title,
                    $description,
                    date('Y-m-d'),
                    $dueDate,
                    1, // default status id
                    1, // default priority id
                    $userId
                ));
                $this->response = ['success' => true];
                break;
            
            case 'edit_status':
                $todoId = $this->form['todoId'] ?? '';
                $newStatus = $this->form['newStatus'] ?? '';
                if (empty($todoId) || empty($newStatus)) {
                    $this->response = ['success' => false, 'error' => 'Todo ID and new status are required'];
                    return;
                }
                $this->service->editStatus($todoId, $newStatus);
                $this->response = ['success' => true];
                break;
            
            case 'delete_todo':
                $todoId = $this->form['todoId'] ?? '';
                if (empty($todoId)) {
                    $this->response = ['success' => false, 'error' => 'Todo ID is required'];
                    return;
                }
                $this->service->delete($todoId);
                $this->response = ['success' => true];
                break;
            
            case 'restore_todo':
                $todoId = $this->form['todoId'] ?? '';
                if (empty($todoId)) {
                    $this->response = ['success' => false, 'error' => 'Todo ID is required'];
                    return;
                }
                $this->service->restore($todoId);
                $this->response = ['success' => true];
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
