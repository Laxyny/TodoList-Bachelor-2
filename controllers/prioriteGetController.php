<?php
	require(ROOT . '/utils/AbstractController.php');
	require(ROOT . '/service/PrioriteService.php');

	class PrioriteGetController extends AbstractController {
		private $service;
		private $priorite;

		public function __construct($form) {
			parent::__construct($form, 'PrioriteGetController');
			$this->service = new PrioriteService();
		}

		protected function checkForm() {
			// Je vais controller si j'ai un id, et je vais le stocker
            if (! isset($this->form['id_priorite'])) {
                error_log(__FUNCTION__. ' listing');
                //Ici je n'ai pas d'id, donc c'est pour un listing
            } else {
                error_log(__FUNCTION__. ' une seule priorite');
                $this->priorite = $this->form['id'];
            }
		}
                protected function checkCybersec() {
			if (isset($this->priorite)) {
                // Est ce que c'est un nombre entier ?
                if (! ctype_digit($this->priorite)) {
                    error_log(__FUNCTION__. ' id est bien un nombre entier');
                } else {
                    _400_Bad_Request();
                }
            }
		}
                protected function checkRights() {
			error_log(__FUNCTION__);
		}

        public function processRequest() {
            try {
                $this->priorite = $this->service->fetchAll();
                error_log('Priorites fetched: ' . print_r($this->priorite, true)); // Log the fetched priorites
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error fetching priorites: ' . $e->getMessage()]);
                exit();
            }
        }
    
        public function processResponse() {
            echo json_encode($this->priorite);
        }
    }
    
    $form = $_GET; // Ou $_POST selon la méthode de votre formulaire
    $controller = new PrioriteGetController($form);
    $controller->processRequest();
    $controller->processResponse();
    ?>