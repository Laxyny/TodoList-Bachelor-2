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
		$stmt = $this->conn->prepare("SELECT * FROM statut");
		if (!$stmt) {
			return [];
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$statuts = [];
		while ($row = $result->fetch_assoc()) {
			$statut = new Statut($row['id_statut'], $row['libelle']);
			$statuts[] = $statut;
		}
		return $statuts;
	}

	public function fetch($id)
	{
	}

	public function create($name) {
        $stmt = $this->conn->prepare("INSERT INTO statuts (name) VALUES (?)");
        if (!$stmt) {
            return ['success' => false, 'error' => $this->conn->error];
        }
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

	public function insert($entity) {
		$stmt = $this->conn->prepare("INSERT INTO statut (libelle) VALUES (?)");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("s", $entity);
        return $stmt->execute();
	}

	public function update($entity)
	{
	}

	public function delete($id) {
		$stmt = $this->conn->prepare("DELETE FROM statuts WHERE id_statut = ?");
        if (!$stmt) {
            return ['success' => false, 'error' => $this->conn->error];
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
	}
}
