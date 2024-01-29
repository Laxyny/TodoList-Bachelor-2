<?php

class DbSingleton {
	private static $_instance = null;
	private $pdo;

	private function __construct() {
		// Database source name
		$DSN = 'mysql:host=localhost;port=3306;dbname=todo';
		try { // create pdo instance
			// We can create it for multiple databases
			$this->pdo = new PDO($DSN, 'todo', 'blabla');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			// Bad credential ? DBMS Driver not found ? Connection fail ?
			die("Error ! : " . $e->getMessage());
		}
	}

	public function getPdo() {
		return $this->pdo;
	}

	public static function getInstance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new DbSingleton();
		}
		return self::$_instance;
	}

	function __destruct() {
		unset($this->pdo);
	}
}

?>
