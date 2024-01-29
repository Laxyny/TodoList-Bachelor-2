<?php
	function headerAndDie($header) {
		header($header);
		die();
	}

	function _405_Method_Not_Allowed() {
		headerAndDie('HTTP/1.1 405 Method Not Allowed');
	}

	function _404_Not_Found() {
		headerAndDie('HTTP/1.1 404 Not Found');
	}

	function _400_Bad_Request() {
		headerAndDie('HTTP/1.1 400 Bad Request');
	}

	function extractForm() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' : return $_GET; 	// Pour recuperer des donnees (READ)
			case 'POST' : return $_POST;	// Pour creer un nouvel enregistrement (CREATE)
			case 'PUT' : return extractRawForm();		// Pour mettre a jour (UPDATE)
			case 'DELETE' : return extractRawForm();	// Pour supprimer (DELETE)
			default : _405_Method_Not_Allowed();
		}
	}

	function extractRawForm() {
		$raw = file_get_contents('php://input');
		$form = [];
		parse_str($raw, $form);
		// var_dump($form);
		return $form;
	}

	function extractRoute($form) {
		if ( ! isset($form['route'])) {
			_404_Not_Found();
		}
		$ROUTE = $form['route'];
		if (preg_match('/^[A-Za-z]+$/', $ROUTE)) {
			return $ROUTE;
		}
		_400_Bad_Request();
	}

	function createController($FORM, $ROUTE) {
		$METHOD = strtolower($_SERVER['REQUEST_METHOD']);	// En minuscule
		$METHOD = ucfirst($METHOD);				// Premiere lettre en majuscule
		// Si mon controlleur s'appelle StatutGet
		// Je charge le fichier '/controllers/StatutGetController.php
		require(ROOT . '/controllers/' . $ROUTE . $METHOD . 'Controller.php');
		// la classe dans ce fichier s'appellera StatutGetController
		$className = $ROUTE . $METHOD . 'Controller';
		$controller = new $className($FORM);
		return $controller;
	}
?>
