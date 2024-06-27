<?php

class Modification
{
	public $id_modification;
	public $date_modification;
	public $raison_modification;
	public $id_todo;

	public function __construct($id_modification, $date_modification, $raison_modification, $id_todo)
	{
		$this->id_modification = $id_modification;
        $this->date_modification = $date_modification;
        $this->raison_modification = $raison_modification;
        $this->id_todo = $id_todo;
	}
}
