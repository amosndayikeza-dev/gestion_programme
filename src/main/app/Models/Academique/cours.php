<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
namespace App\Models\academique;
class Cours
{
    private  $id_cours;
    private  $titre ;
    private  $description;
    private  $id_matiere;
    private  $id_programme;
    private  $id_classe;
    private  $statut;
    private  $ordre_progression;
    private  $niveau_difficulte;
    private  $dureeEstimee;
    private  $type_cours;
    private  $objectif_apprentissage;
    private  $prerequis;
    private  $ressources_externes;
    private  $nb_vues;
    private  $taux_reussite;
    private  $seuil_reussite;
    private  $createurId;
    private  $visible;

    public function __construct(
         $id_cours = null,
         $titre = null,
         $description = null,
         $id_matiere = null,
         $id_programme = null,
         $id_classe = null,
         $statut = null,
         $ordre_progression = null,
         $niveau_difficulte = null,
         $dureeEstimee = null,
         $modification = null,
         $typeCours = null,
         $objectifApprentissage = null,
         $prerequis = null,
         $ressourcesExternes = null,
         $nbVues = null,
         $tauxReussite = null,
         $seuilReussite = null,
         $createurId = null,
         $visible = null,
    ) {
        $this->id_cours = $id_cours;
        $this->titre = $titre;
        $this->description = $description;
        $this->id_matiere = $id_matiere;
        $this->id_programme = $id_programme;
        $this->id_classe = $id_classe;
        $this->statut = $statut;
        $this->ordre_progression = $ordre_progression;
        $this->niveau_difficulte = $niveau_difficulte;
        $this->dureeEstimee = $dureeEstimee;
        $this->type_cours = $typeCours;
        $this->objectif_apprentissage = $objectifApprentissage;
        $this->prerequis = $prerequis;
        $this->ressources_externes = $ressourcesExternes;
        $this->nb_vues = $nbVues;
        $this->taux_reussite = $tauxReussite;
        $this->seuil_reussite = $seuilReussite;
        $this->createurId = $createurId;
        $this->visible = $visible;
    }

   public function getIdCours() { return $this->id_cours; }
    public function setIdCours( $id) { $this->id_cours = $id; }
   
    public function getTitre() { return $this->titre; }
    public function setTitre( $titre) { $this->titre = $titre; }

    public function getDescription() { return $this->description; }
    public function setDescription($desc) { $this->description = $desc; }

    public function getIdMatiere() { return $this->id_matiere; }
    public function setIdMatiere( $id) { $this->id_matiere = $id; }

    public function getIdProgramme() { return $this->id_programme; }
    public function setIdProgramme( $id) { $this->id_programme = $id; }
    
    public function getIdClasse() { return $this->id_classe; }
    public function setIdClasse( $id) { $this->id_classe = $id; }

    public function getStatut() { return $this->statut; }
    public function setStatut( $statut) { $this->statut = $statut; }

    public function getOrdreProgression() { return $this->ordre_progression; }      
    public function setOrdreProgression( $ordre) { $this->ordre_progression = $ordre; }

    public function getNiveauDifficulte() { return $this->niveau_difficulte; }
    public function setNiveauDifficulte( $niveau) { $this->niveau_difficulte = $niveau; }

    public function getDureeEstimee() { return $this->dureeEstimee; }
    public function setDureeEstimee( $duree) { $this->dureeEstimee = $duree; }

    public function getTypeCours() { return $this->type_cours; }
    public function setTypeCours( $type) { $this->type_cours = $type; }

    public function getObjectifApprentissage() { return $this->objectif_apprentissage; }
    public function setObjectifApprentissage( $objectif) { $this->objectif_apprentissage = $objectif; }

    public function getPrerequis() { return $this->prerequis; }
    public function setPrerequis( $prerequis) { $this->prerequis = $prerequis; }

    public function getRessourcesExternes() { return $this->ressources_externes; }
    public function setRessourcesExternes( $ressources) { $this->ressources_externes = $ressources; }

    public function getNbVues() { return $this->nb_vues; }
    public function setNbVues( $vues) { $this->nb_vues = $vues; }

    public function getTauxReussite() { return $this->taux_reussite; }
    public function setTauxReussite( $taux) { $this->taux_reussite = $taux; }

    public function getSeuilReussite() { return $this->seuil_reussite; }
    public function setSeuilReussite( $seuil) { $this->seuil_reussite = $seuil; }

    public function getCreateurId() { return $this->createurId; }
    public function setCreateurId( $id) { $this->createurId = $id; }

    public function getVisible() { return $this->visible; }
    public function setVisible( $visible) { $this->visible = $visible; }


}