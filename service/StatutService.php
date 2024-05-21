<?php
require_once(ROOT . '/utils/AbstractService.php');
require_once(ROOT . '/utils/BaseService.php');
require_once(ROOT . '/dao/StatutDao.php');

class StatutService extends AbstractService implements BaseService
{
	private $statutDao;

	public function __construct()
	{
		$this->statutDao = new StatutDao(DbSingleton::getInstance()->getConnection());
	}

	public function fetchAll()
	{
		return $this->statutDao->fetchAll();
	}

	public function fetch($id)
	{
		// Implémentation si nécessaire
	}

	public function insert($entity)
	{
		// Implémentation si nécessaire
	}

	public function update($entity)
	{
		// Implémentation si nécessaire
	}

	public function delete($id)
	{
		// Implémentation si nécessaire
	}
}
