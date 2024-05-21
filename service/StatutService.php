<?php
	require_once(ROOT . '/utils/AbstractService.php');
	require_once(ROOT . '/utils/BaseService.php');
	require_once(ROOT . '/dao/StatutDao.php');

	class StatutService extends AbstractService implements BaseService {

		private $statutDao;

		function __construct() {
			// On n'utilise que les méthodes de l'interface
			//$this->statutDao = new StatutDao();
			$this->statutDao = new StatutDao(DbSingleton::getInstance()->getConnection());
		}

		function fetchAll() {
			$list = $this->statutDao->fetchAll();
			return $list;
		}

                public function fetch($id) {
		}

                public function insert($entity) {
		}

                public function update($entity) {
		}

                public function delete($id) {
		}

	}
?>
