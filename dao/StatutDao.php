<?php
	require_once(ROOT . '/utils/AbstractDao.php');
	require_once(ROOT . '/utils/BaseDao.php');
	require_once(ROOT . '/utils/DbSingleton.php');
	require_once(ROOT . '/model/Statut.php');

	class StatutDao extends AbstractDao implements BaseDao {

		private $statutDao;

		function __construct() {
		}

		function fetchAll() {
			$pdo = DbSingleton::getInstance()->getPdo();
			$sql = "SELECT * FROM Statut;";
			$sth = $pdo->query($sql);
			$result = $sth->fetchAll(PDO::FETCH_OBJ);
			$statuts = array();
			foreach($result as $row) {
				$statut = new Statut();
				$statut->setId( intval($row->Statut) );
				$statut->setLabel( $row->label );
				array_push($statuts, $statut);
			}
			return $statuts;
		}

                public function fetch($id) { }

                public function insert($entity) { }

                public function update($entity) { }

                public function delete($id) { }
	}
?>
