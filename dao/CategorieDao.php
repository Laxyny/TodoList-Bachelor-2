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
			error_log('Error preparing statement: ' . $this->conn->error);
			return [];
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$categories = [];
		while ($row = $result->fetch_assoc()) {
			error_log('Row data: ' . print_r($row, true)); // Log the row data
			$categorie = new Categorie($row['id_categorie'], $row['libelle']);
			$categories[] = $categorie;
			error_log('Categorie object created: ' . print_r($categorie, true)); // Log each object
		}
		error_log('Data fetched from database: ' . print_r($categories, true)); // Log the fetched data
		return $categories;
	}

	public function fetch($id)
	{
	}

	public function create($name) {
        $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (?)");
        if (!$stmt) {
            error_log('Error preparing statement: ' . $this->conn->error);
            return ['success' => false, 'error' => $this->conn->error];
        }
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

	public function insert($entity) {
		$stmt = $this->conn->prepare("INSERT INTO categories (libelle) VALUES (?)");
        if (!$stmt) {
            error_log('Error preparing statement: ' . $this->conn->error);
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
			error_log('Error preparing statement: ' . $this->conn->error);
			return false;
		}
		$stmt->bind_param("i", $id);
		return $stmt->execute();
	}
}
