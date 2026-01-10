<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Cours
{
    private  $idCours;
    private  $titre ;
    private  $description;
    private  $idMatiere;
    private  $idProgramme;
    private  $idClasse;
    private  $statut;
    private $ordre_progression;
    private $niveau_difficulte;
    private $dureeEstimee;
    private $datecreation;
    private $modification;
    private $typeCours;
    private $objectifApprentissage;
    private $prerequis;
    private $ressourcesExternes;
    private $nbVues;
    private $tauxReussite;
    private $seuilReussite;
    private $createurId;
    private $visible;
    private $tags;


    public function __construct(
         $idCours,
         $titre,
         $description,
         $idMatiere,
         $idProgramme,
         $idClasse,
         $statut,
        $ordre_progression,
        $niveau_difficulte,
        $dureeEstimee,
        $datecreation,
        $modification,
        $typeCours,
        $objectifApprentissage,
        $prerequis,
        $ressourcesExternes,
        $nbVues,
        $tauxReussite,
        $seuilReussite,
        $createurId,
        $visible,
        $tags,
    ) {
        $this->idCours = $idCours;
        $this->titre = $titre;
        $this->description = $description;
        $this->idMatiere = $idMatiere;
        $this->idProgramme = $idProgramme;
        $this->idClasse = $idClasse;
        $this->statut = $statut;
    }

    public function getIdCours()  { return $this->idCours; }
    public function setIdCours( $id) { $this->idCours = $id; }

    public function getTitre() { return $this->titre; }
    public function setTitre( $titre) { $this->titre = $titre; }

    public function getDescription() { return $this->description; }
    public function setDescription($desc) { $this->description = $desc; }

    public function getIdMatiere() { return $this->idMatiere; }
    public function setIdMatiere( $id) { $this->idMatiere = $id; }

    public function getIdProgramme() { return $this->idProgramme; }
    public function setIdProgramme( $id) { $this->idProgramme = $id; }

    public function getIdClasse() { return $this->idClasse; }
    public function setIdClasse( $id) { $this->idClasse = $id; }

    public function getStatut() { return $this->statut; }
    public function setStatut( $statut) { $this->statut = $statut; }

    public function getOrdreProgression() { return $this->ordre_progression; }      
    public function setOrdreProgression( $ordre) { $this->ordre_progression = $ordre; }

    public function getNiveauDifficulte() { return $this->niveau_difficulte; }
    public function setNiveauDifficulte( $niveau) { $this->niveau_difficulte = $niveau; }

    public function getDureeEstimee() { return $this->dureeEstimee; }
    public function setDureeEstimee( $duree) { $this->dureeEstimee = $duree; }

    public function getDateCreation() { return $this->datecreation; }
    public function setDateCreation( $date) { $this->datecreation = $date; }

    public function getModification() { return $this->modification; }
    public function setModification( $modif) { $this->modification = $modif; }

    public function getTypeCours() { return $this->typeCours; }
    public function setTypeCours( $type) { $this->typeCours = $type; }

    public function getObjectifApprentissage() { return $this->objectifApprentissage; }
    public function setObjectifApprentissage( $objectif) { $this->objectifApprentissage = $objectif; }

    public function getPrerequis() { return $this->prerequis; }
    public function setPrerequis( $prerequis) { $this->prerequis = $prerequis; }

    public function getRessourcesExternes() { return $this->ressourcesExternes; }
    public function setRessourcesExternes( $ressources) { $this->ressourcesExternes = $ressources; }

    public function getNbVues() { return $this->nbVues; }
    public function setNbVues( $vues) { $this->nbVues = $vues; }

    public function getTauxReussite() { return $this->tauxReussite; }
    public function setTauxReussite( $taux) { $this->tauxReussite = $taux; }

    public function getSeuilReussite() { return $this->seuilReussite; }
    public function setSeuilReussite( $seuil) { $this->seuilReussite = $seuil; }

    public function getCreateurId() { return $this->createurId; }
    public function setCreateurId( $id) { $this->createurId = $id; }

    public function getVisible() { return $this->visible; }
    public function setVisible( $visible) { $this->visible = $visible; }

    public function getTags() { return $this->tags; }
    public function setTags( $tags) { $this->tags = $tags; }    


}
//$cours = new Cours();
//$cours->getTitre();