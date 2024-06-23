<?php
class Utilisateur {
    public $id_utilisateur;
    public $utilisateur;
    public $mot_de_passe;
    public $role;

    public function __construct($id_utilisateur, $utilisateur, $mot_de_passe, $role) {
        $this->id_utilisateur = $id_utilisateur;
        $this->utilisateur = $utilisateur;
        $this->mot_de_passe = $mot_de_passe;
        $this->role = $role;
    }
}
?>
