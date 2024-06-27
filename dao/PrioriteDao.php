<?php
require_once(ROOT . '/utils/AbstractDao.php');
require_once(ROOT . '/utils/BaseDao.php');
require_once(ROOT . '/utils/DbSingleton.php');
require_once(ROOT . '/utils/functions.php');
require_once(ROOT . '/model/Priorite.php');

class PrioriteDao extends AbstractDao implements BaseDao
{

	private $prioriteDao;

	function __construct($prioriteDao)
	{
		$this->prioriteDao = $prioriteDao;
	}

	public function fetchAll()
	{
		$stmt = $this->prioriteDao->prepare("SELECT id_priorite, libelle FROM priorites");
		if (!$stmt) {
			return [];
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$priorites = [];
		while ($row = $result->fetch_assoc()) {
			$priorites[] = $row;
		}
		return $priorites;
	}

	public function fetch($id)
	{
		$pdo = DbSingleton::getInstance()->getPdo();
		//TODO Faire un prepared statement
		$sql = "SELECT * FROM priorites p WHERE p.Priorite =" . $id . ";";
		$sth = $pdo->prepare($sql);
		$result = $sth->fetch(PDO::FETCH_OBJ);
		// Si result est false , ça n'existe pas donc 404
		if (!$result) {
			_404_Not_Found();
		}
		$prio = new Priorite();
		$prio->setId(intval($result->Priorite));
		$prio->setLabel($result->label);
		return $prio;
	}

	public function insert($entity) {
		$stmt = $this->prioriteDao->prepare("INSERT INTO priorite (libelle) VALUES (?)");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("s", $entity);
        return $stmt->execute();
	}

	public function update($entity)
	{
	}

	public function delete($id)
	{
	}
}
