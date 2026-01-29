<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/ProgrammeDAO.php";
require_once __DIR__ ."../../../dao/Academique/CoursDAO.php";
class ProgrammeService {
    private ProgrammeDAO $programme_dao;
    private CoursDAO $cours_dao;

    public function __construct()
    {
      $$this->programme_dao = new ProgressionDAO();
      $this->cours_dao = new CoursDAO();
    }
    /**
     * Ajouter un programme
     */
    public function ajouterProgramme(Programme $programme){
      return $this->programme_dao->CreateProgramme($programme);
    }
    /**
     * Modifier un programme
     */
  public function modifierProgramme(Programme $programme){
    return $this->programme_dao->UpdateProgramme($programme);
  }
  /**
   * Afficher un programme
   */
  public function afficherProgramme($id_programme){
    return $this->programme_dao->getOneProgramme($id_programme);
  }

  /**
   * afficher touts les programmes
   */
  public function afficherProgrammes(){
    return $this->programme_dao->getALLProgramme();
  }
  /**
   * supprimerProgramme
   */
  public function supprimerProgramme($id_programme){
    return $this->programme_dao->DeleteProgramme($id_programme);
  }














  
  /*// publier un programme
  public function publierProgramme($id_programme){
    //verifier si un programme existe
    $programme = $this->programme_dao->getOneProgramme($id_programme);
    if(! $programme){
      throw new Exception("L programme existe deja");
    }
    //verifier que le programme n'est pas deja publier
    if($programme->getStatut = "PUBLIE"){
      throw new Exception("Le programme est deja publier");
    }

    //verifier que le programme contient aumoin un cours
    $nbCours = $this->cours_dao->countByProgramme($id_programme);
    if($nbCours < 1){
      throw new Exception("Impossible de publir un programme qui n'a pas cours");
    }

    //changer le statut
    $programme->setStatut("PUBLIE");
    $programme->setDatePublication( new DateTime());

    //changer dans la base des donnees
    $this->programme_dao->UpdateProgramme($id_programme);
  }
*/
}
?>