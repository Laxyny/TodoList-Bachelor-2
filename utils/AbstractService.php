<?php

	abstract class AbstractService {

		abstract function fetchAll();

                abstract function fetch($id);

                abstract function insert($entity);

                abstract function update($entity);

                abstract function delete($id);

	}
?>
