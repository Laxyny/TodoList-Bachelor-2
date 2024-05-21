<?php
class Todo {
    public $id_todo;
    public $titre;
    public $description;
    public $date_creation;
    public $date_echeance;
    public $id_statut;
    public $id_priorite;
    public $id_utilisateur;

    public function __construct($id_todo, $titre, $description, $date_creation, $date_echeance, $id_statut, $id_priorite, $id_utilisateur) {
        $this->id_todo = $id_todo;
        $this->titre = $titre;
        $this->description = $description;
        $this->date_creation = $date_creation;
        $this->date_echeance = $date_echeance;
        $this->id_statut = $id_statut;
        $this->id_priorite = $id_priorite;
        $this->id_utilisateur = $id_utilisateur;
    }
}
?>
