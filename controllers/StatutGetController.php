<?php
	require(ROOT . '/utils/AbstractController.php');
	require(ROOT . '/service/StatutService.php');

	class StatutGetController extends AbstractController {
		private $service;

		private $statuts;

		public function __construct($form) {
			parent::__construct($form, 'StatutGetController');
			$this->service = new StatutService();
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
                protected function processRequest() {
			$this->statuts = $this->service->fetchAll();
		}
                protected function processResponse() {
			echo json_encode($this->statuts);
		}

	}
?>
