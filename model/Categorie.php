<?php

class Categorie
{
	public $id_categorie;
	public $libelle;

	public function __construct($id_categorie, $libelle)
	{
		$this->id_categorie = $id_categorie;
		$this->libelle = $libelle;
	}
}
