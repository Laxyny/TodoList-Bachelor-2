<?php
define('ROOT', dirname(__DIR__));

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
        $action = $_GET['action'] ?? '';
        $userId = $_GET['userId'] ?? null;
    
        if ($action === 'fetch_deleted') {
            try {
                $this->todos = $this->service->fetchDeletedTodos();
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error fetching deleted todos: ' . $e->getMessage()]);
                exit();
            }
        } else if ($userId) {
            try {
                $this->todos = $this->service->fetchAllByUser($userId);
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error fetching todos: ' . $e->getMessage()]);
                exit();
            }
        } else {
            echo json_encode(['error' => 'Invalid request']);
            exit();
        }
    }

    public function processResponse() {
        echo json_encode($this->todos);
    }
}

$form = $_GET;
$controller = new TodoGetController($form);
$controller->processRequest();
$controller->processResponse();
?>
