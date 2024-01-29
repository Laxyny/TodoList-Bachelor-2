<?php

	interface BaseService {

		function fetchAll();

                function fetch($id);

                function insert($entity);

                function update($entity);

                function delete($id);

	}
?>
