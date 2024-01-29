<?php
	abstract class AbstractController {
		protected $form;
		protected $controllerName;

		protected function __construct($form, $controllerName) {
			$this->form = $form;
			$this->controllerName = $controllerName;
		}

		public function execute() {
			$this->checkForm();
			$this->checkCybersec();
			$this->checkRights();
			$this->processRequest();
			$this->processResponse();
		}

		abstract protected function checkForm();
		abstract protected function checkCybersec();
		abstract protected function checkRights();
		abstract protected function processRequest();
		abstract protected function processResponse();
	}
?>
