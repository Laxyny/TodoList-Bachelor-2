<?php

class Utilisateur
{
	public $id_utilisateur;
	public $email;
    public $mot_de_passe;

	public function __construct($id_utilisateur, $email, $mot_de_passe)
	{
		$this->id_utilisateur = $id_utilisateur;
		$this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
	}
}