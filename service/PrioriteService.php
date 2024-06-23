<?php
	require_once(ROOT . '/utils/AbstractService.php');
	require_once(ROOT . '/utils/BaseService.php');
	require_once(ROOT . '/dao/PrioriteDao.php');

	class PrioriteService extends AbstractService implements BaseService {

		private $prioriteDao;

		function __construct() {
			// On n'utilise que les méthodes de l'interface
			$this->prioriteDao = new PrioriteDao(DbSingleton::getInstance()->getConnection());
		}

		function fetchAll() {
			return $this->prioriteDao->fetchAll();
		}

                public function fetch($id) {
                    return $this->prioriteDao->fetch($id);
		}

                public function insert($entity) {
					return $this->prioriteDao->insert($entity);
		}

                public function update($entity) {
		}

                public function delete($id) {
		}

	}
?>
