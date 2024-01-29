<?php
	require_once(ROOT . '/utils/AbstractService.php');
	require_once(ROOT . '/utils/BaseService.php');
	require_once(ROOT . '/dao/PrioriteDao.php');

	class PrioriteService extends AbstractService implements BaseService {

		private $dao;

		function __construct() {
			// On n'utilise que les méthodes de l'interface
			$this->dao = new PrioriteDao();
		}

		function fetchAll() {
			$list = $this->dao->fetchAll();
			return $list;
		}

                public function fetch($id) {
                    return $this->dao->fetch($id);
		}

                public function insert($entity) {
		}

                public function update($entity) {
		}

                public function delete($id) {
		}

	}
?>
