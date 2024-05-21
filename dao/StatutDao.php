<?php
require_once(ROOT . '/utils/AbstractDao.php');
require_once(ROOT . '/utils/BaseDao.php');
require_once(ROOT . '/utils/DbSingleton.php');
require_once(ROOT . '/model/Statut.php');

class StatutDao extends AbstractDao implements BaseDao
{

	private $conn;

	public function __construct($conn)
	{
		$this->conn = $conn;
	}

	public function fetchAll()
	{
		$stmt = $this->conn->prepare("SELECT * FROM statuts");
		$stmt->execute();
		$result = $stmt->get_result();
		$statuts = [];
		while ($row = $result->fetch_assoc()) {
			$statuts[] = new Statut($row['id_statut'], $row['libelle']);
		}
		return $statuts;
	}

	public function fetch($id)
	{
	}

	public function insert($entity)
	{
	}

	public function update($entity)
	{
	}

	public function delete($id)
	{
	}
}
