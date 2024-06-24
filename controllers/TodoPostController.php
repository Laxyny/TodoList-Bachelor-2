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
        error_log('TodoPostController action: ' . $action);

        switch ($action) {
            case 'create_todo':
                $this->response = $this->service->create($this->form);
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

                case 'restore_todo_admin':
                    $todoId = $this->form['todoId'] ?? null;
                    if ($todoId) {
                        $result = $this->service->restore($todoId, 2); // 2 correspond à "En cours"
                        if ($result) {
                            $this->response = ['success' => true];
                        } else {
                            $this->response = ['success' => false, 'error' => 'Failed to restore todo'];
                        }
                    } else {
                        $this->response = ['success' => false, 'error' => 'Todo ID is required'];
                    }
                    break;

                    case 'edit_todo':
                        $todoId = $this->form['todoId'] ?? '';
                        $newTitle = $this->form['newTitle'] ?? '';
                        $newDescription = $this->form['newDescription'] ?? '';
                        $newDueDate = $this->form['newDueDate'] ?? '';
                        $newStatus = $this->form['newStatus'] ?? '';
                        $newPriority = $this->form['newPriority'] ?? '';
                        $newCategorie = $this->form['newCategorie'] ?? '';
                        if (empty($newTitle) || empty($newDescription) || empty($newDueDate) || empty($todoId) || empty($newStatus) || empty($newPriority) || empty($newCategorie)) {
                            $this->response = ['success' => false, 'error' => 'Les champs ne sont pas remplis'];
                            return;
                        }
                        $this->service->editStatus($todoId, $newTitle, $newDescription, $newDueDate, $newStatus, $newPriority, $newCategorie);
                        $this->response = ['success' => true];
                        break;
            
            default:
                $this->response = ['success' => false, 'error' => 'Invalid action'];
        }
        error_log('TodoPostController response: ' . print_r($this->response, true));
    }

    public function processResponse() {
        header('Content-Type: application/json');
        $jsonResponse = json_encode($this->response);
        error_log('TodoPostController JSON response: ' . $jsonResponse);
        echo $jsonResponse;
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
