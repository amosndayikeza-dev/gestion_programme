<?php
 class programmes{
    private $id_programmes;
    private $nom_programme;
    private $ministere_source;
    private $niveau;
    private $description;
    private $date_creation;
    private $date_debut;
    private $date_fin;
    private $statut;
    private $objectifs_programme;
    private $competences_visees;
    private $modalite_evaluation;
    private $prerequis_programme;
    private $duree_total;
    private $nb_matiere;
    private $nb_cours_total;
    private $version;

    public function __construct($id_programmes,$nom_programm,$ministere_source,$niveau,
    $description,$date_creation,$date_debut,$date_fin,$statut,$objectifs_programme,
    $competences_visees,$modalite_evaluation,$prerequis_programme,$duree_total,$nb_matiere,$nb_cours_total,$version)
    {
        $this->id_programmes = $id_programmes;
        $this->nom_programme =$nom_programm;
        $this->ministere_source = $ministere_source;
        $this->niveau = $niveau;
        $this->description = $description;
        $this->date_creation = $date_creation;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->statut = $statut;
        $this->objectifs_programme = $objectifs_programme;
        $this->competences_visees = $competences_visees;
        $this->competences_visees = $competences_visees;
        $this->modalite_evaluation = $modalite_evaluation;
        $this->prerequis_programme = $prerequis_programme;
        $this->duree_total = $duree_total;
        $this->nb_matiere = $nb_matiere;
        $this->nb_cours_total = $nb_cours_total;
        $this->version = $version;
    }
 }


?>

