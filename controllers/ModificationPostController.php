<?php
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/ModificationService.php');

class ModificationPostController extends AbstractController {
    private $service;
    private $modification;

    public function __construct($form) {
        parent::__construct($form, 'ModificationPostController');
        $this->service = new ModificationService();
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

        $entity = $this->form['raison'] ?? null;
        $id = $this->form['todoId'] ?? null;

        switch ($action) {
            case 'raison_modif':
                try {
                    $this->modification = $this->service->create($entity, $id);
                } catch (Exception $e) {
                    echo json_encode(['error' => 'Error fetching raison modification: ' . $e->getMessage()]);
                    exit();
                }
                break;

            default:
                $this->modification = ['success' => false, 'error' => 'Invalid action'];
        }
    }

    public function processResponse() {
        echo json_encode($this->modification);
    }
}

try {
    $form = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON input: ' . json_last_error_msg());
    }
    $controller = new ModificationPostController($form);
    $controller->processRequest();
    $controller->processResponse();
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Internal server error: ' . $e->getMessage()]);
}
?>
