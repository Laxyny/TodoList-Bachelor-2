<?php

	class Statut {

		public int $id;
		public string $label;

		function __construct() {
		}

		public function getId() : int {
			return $this->id;
		}
		public function getLabel() : string {
			return $this->label;
		}

		public function setId(int $_id) {
                        $this->id = $_id;
                }
                public function setLabel(string $_label) {
                        $this->label = $_label;
                }

	}

?>
