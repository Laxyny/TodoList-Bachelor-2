<?php
require_once(ROOT . '/utils/AbstractDao.php');
require_once(ROOT . '/utils/BaseDao.php');
require_once(ROOT . '/utils/DbSingleton.php');
require_once(ROOT . '/model/Categorie.php');
require_once(ROOT . '../database.php');

class CategorieDao extends AbstractDao implements BaseDao
{

	private $conn;

	public function __construct($conn)
	{
		$this->conn = $conn;
	}

	public function fetchAll()
	{
		$stmt = $this->conn->prepare("SELECT * FROM categories");
		if (!$stmt) {
			return [];
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$categories = [];
		while ($row = $result->fetch_assoc()) {
			$categorie = new Categorie($row['id_categorie'], $row['libelle']);
			$categories[] = $categorie;
		}
		return $categories;
	}

	public function fetch($id)
	{
	}

	public function create($name) {
        $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (?)");
        if (!$stmt) {
            return ['success' => false, 'error' => $this->conn->error];
        }
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

	public function insert($entity) {
		$stmt = $this->conn->prepare("INSERT INTO categories (libelle) VALUES (?)");
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
		$stmt = $this->conn->prepare("DELETE FROM categories WHERE id_categorie = ?");
		if (!$stmt) {
			return false;
		}
		$stmt->bind_param("i", $id);
		return $stmt->execute();
	}
}
