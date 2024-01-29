<?php
	define("ROOT", dirname(__FILE__)); // va nous servir de racine pour le chargement des fichiers
	require_once(ROOT . '/utils/functions.php');
	$FORM = extractForm();		// Extract le formulaire en fonction de la methode HTTP
	$ROUTE = extractRoute($FORM);	// J'ai mon formulaire, je peux extraire la route
	echo $ROUTE;
	// J'ai ma route, donc je peux charger mon controleur
	$controller = createController($FORM, $ROUTE);
	$controller->execute();
?>

