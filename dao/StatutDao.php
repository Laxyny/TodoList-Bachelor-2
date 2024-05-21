<?php
require_once(ROOT . '/utils/AbstractDao.php');
require_once(ROOT . '/utils/BaseDao.php');
require_once(ROOT . '/utils/DbSingleton.php');
require_once(ROOT . '/model/Statut.php');
require_once(ROOT . '../database.php');

class StatutDao extends AbstractDao implements BaseDao
{

	private $conn;

	public function __construct($conn)
	{
		$this->conn = $conn;
	}

	public function fetchAll()
	{
		$stmt = $this->conn->prepare("SELECT id_statut, libelle FROM statuts");
		if (!$stmt) {
			error_log('Error preparing statement: ' . $this->conn->error);
			return [];
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$statuts = [];
		while ($row = $result->fetch_assoc()) {
			error_log('Row data: ' . print_r($row, true)); // Log the row data
			$statut = new Statut($row['id_statut'], $row['libelle']);
			$statuts[] = $statut;
			error_log('Statut object created: ' . print_r($statut, true)); // Log each object
		}
		error_log('Data fetched from database: ' . print_r($statuts, true)); // Log the fetched data
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
