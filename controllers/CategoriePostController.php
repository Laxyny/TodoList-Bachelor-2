<?php
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/CategorieService.php');

class CategoriePostController extends AbstractController {
    private $service;
    private $response;

    public function __construct($form) {
        parent::__construct($form, 'CategoriePostController');
        $this->service = new CategorieService();
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
            case 'create_categorie':
                $name = $this->form['name'] ?? '';
                if (empty($name)) {
                    $this->response = ['success' => false, 'error' => 'Name is required'];
                    return;
                }
                $this->service->insert($name);
                $this->response = ['success' => true];
                break;

            case 'delete_categorie_admin':
                $id = $this->form['categorieId'] ?? '';
                if (empty($id)) {
                    $this->response = ['success' => false, 'error' => 'ID is required'];
                    return;
                }
                $this->service->delete($id);
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
    $form = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON input: ' . json_last_error_msg());
    }
    $controller = new CategoriePostController($form);
    $controller->processRequest();
    $controller->processResponse();
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Internal server error: ' . $e->getMessage()]);
}
?>
