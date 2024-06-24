<?php
require_once(ROOT . '/utils/AbstractService.php');
require_once(ROOT . '/utils/BaseService.php');
require_once(ROOT . '/dao/CategorieDao.php');

class CategorieService extends AbstractService implements BaseService
{
	private $categorieDao;

	public function __construct()
	{
		$this->categorieDao = new CategorieDao(DbSingleton::getInstance()->getConnection());
	}

	public function fetchAll()
	{
		return $this->categorieDao->fetchAll();
	}

	public function fetch($id)
	{
		// Implémentation si nécessaire
	}

	public function insert($entity)
	{
		return $this->categorieDao->insert($entity);
	}

	public function update($entity)
	{
		// Implémentation si nécessaire
	}

	public function delete($id)
	{
		return $this->categorieDao->delete($id);
	}
}
