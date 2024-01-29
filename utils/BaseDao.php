<?php

	interface BaseDao {

		public function fetchAll();

		public function fetch($id);

		public function insert($entity);

		public function update($entity);

		public function delete($id);

	}
?>
