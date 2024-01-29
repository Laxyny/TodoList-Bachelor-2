<?php
	require_once(ROOT . '/utils/AbstractDao.php');
	require_once(ROOT . '/utils/BaseDao.php');
	require_once(ROOT . '/utils/DbSingleton.php');
    require_once(ROOT . '/utils/functions.php');
	require_once(ROOT . '/model/Priorite.php');

	class PrioriteDao extends AbstractDao implements BaseDao {

		//private $prioriteDao;

		function __construct() {
		}

		function fetchAll() {
			$pdo = DbSingleton::getInstance()->getPdo();
			$sql = "SELECT * FROM Priorite;";
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

                public function fetch($id) {
                    $pdo = DbSingleton::getInstance()->getPdo();
                    //TODO Faire un prepared statement
                    $sql = "SELECT * FROM Priorite p WHERE p.Priorite =" . $id . ";";
                    $sth = $pdo->prepare($sql);
                    $result = $sth->fetch(PDO::FETCH_OBJ);
                    // Si result est false , ça n'existe pas donc 404
                    if (!$result) {
                        _404_Not_Found();
                    }
                    $prio = new Priorite();
                    $prio->setId( intval($result->Priorite) );
                    $prio->setLabel( $result->label );
                    return $prio;
                }

                public function insert($entity) { }

                public function update($entity) { }

                public function delete($id) { }
	}
?>
