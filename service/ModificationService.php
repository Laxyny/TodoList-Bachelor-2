<?php
require_once(ROOT . '/utils/AbstractService.php');
require_once(ROOT . '/utils/BaseService.php');
require_once(ROOT . '/dao/ModificationDao.php');
require_once(ROOT . '/utils/DbSingleton.php');

class ModificationService extends AbstractService implements BaseService
{

    private $modificationDao;

    function __construct()
    {
        $this->modificationDao = new ModificationDao(DbSingleton::getInstance()->getConnection());
    }

    function fetchAll()
    {
        return $this->modificationDao->fetchAll();
    }

    public function fetch($id)
    {
        return $this->modificationDao->fetch($id);
    }

    public function insert($entity)
    {
        return $this->modificationDao->insert($entity);
    }

    public function update($entity)
    {
    }

    public function delete($id)
    {
    }

    public function create($entity, $id)
    {
        return $this->modificationDao->create($entity, $id);
    }
}
