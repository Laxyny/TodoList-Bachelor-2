<?php
//define('ROOT', __DIR__ . '/../');
define('ROOT', dirname(__DIR__));

require(ROOT . '/utils/AbstractController.php');
require(ROOT . '/service/ModificationService.php');

class ModificationGetController extends AbstractController
{
    private $service;
    private $modification;

    public function __construct($form)
    {
        parent::__construct($form, 'ModificationGetController');
        $this->service = new ModificationService();
    }

    protected function checkForm()
    {
        // Je vais controller si j'ai un id, et je vais le stocker
        if (!isset($this->form['id_modification'])) {
            error_log(__FUNCTION__ . ' listing');
            //Ici je n'ai pas d'id, donc c'est pour un listing
        } else {
            error_log(__FUNCTION__ . ' une seule modification');
            $this->modification = $this->form['id_modification'];
        }
    }
    protected function checkCybersec()
    {
        if (isset($this->modification)) {
            // Est ce que c'est un nombre entier ?
            if (!ctype_digit($this->modification)) {
                error_log(__FUNCTION__ . ' id est bien un nombre entier');
            } else {
                _400_Bad_Request();
            }
        }
    }
    protected function checkRights()
    {
        error_log(__FUNCTION__);
    }

    public function processRequest()
    {
        $action = $this->form['action'] ?? null;
        $id = $this->form['todoId'] ?? null;

        error_log("Action: $action");
        error_log("Todo ID: $id");

        switch ($action) {
            case 'fetch_modifications':
                try {
                    $this->modification = $this->service->fetch($id);
                    error_log('Modifications: ' . print_r($this->modification, true));
                } catch (Exception $e) {
                    echo json_encode(['error' => 'Error fetching modifications: ' . $e->getMessage()]);
                    exit();
                }
                break;

            default:
                $this->modification = ['success' => false, 'error' => 'Invalid action'];
        }
    }

    public function processResponse()
    {
        echo json_encode($this->modification);
    }
}

$form = $_GET;
$controller = new ModificationGetController($form);
$controller->processRequest();
$controller->processResponse();
