<?php
require_once(ROOT . '/utils/AbstractDao.php');
require_once(ROOT . '/utils/DbSingleton.php');
require_once(ROOT . '/model/Modification.php');
require_once(ROOT . '/database.php');

class ModificationDao extends AbstractDao implements BaseDao {

	private $conn;

	public function __construct($conn)
	{
		$this->conn = $conn;
	}

	public function fetchAll()
	{
	}

	public function fetch($id) {
		$stmt = $this->conn->prepare("SELECT * FROM modifications WHERE id_todo = ?");
        if (!$stmt) {
            return [];
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $modifications = [];
        while ($row = $result->fetch_assoc()) {
			$modification = new Modification($row['id_modification'], $row['date_modification'], $row['raison_modification'], $row['id_todo']);
			$modifications[] = $modification;
        }
        return $modifications;
	}

	public function create($entity, $id)
	{
		$stmt = $this->conn->prepare("INSERT INTO modifications (raison_modification, date_modification, id_todo) VALUES (?, ?, ?)");
        if (!$stmt) {
            return false;
        }
		
		$date = date("Y-m-d");
		error_log('Date du jour: ' . $date);
		
        $stmt->bind_param("ssi", $entity, $date, $id);
        return $stmt->execute();
	}

	public function insert($entity) {
	}

	public function update($entity)
	{
	}

	public function delete($id)
	{
	}
}
