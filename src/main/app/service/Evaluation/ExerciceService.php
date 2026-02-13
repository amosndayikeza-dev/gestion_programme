<?php
namespace App\Service\Evaluation;


use App\Dao\Evaluation\ExerciceDAO;
use App\Models\Evaluation\Exercice;
use App\Dao\Evaluation\ResultatDAO;
use App\Models\Evaluation\Resultat;
use Exception;

//require_once __DIR__ . "/../../dao/Evaluation/ExerciceDAO.php";
//require_once __DIR__ . "/../../dao/Evaluation/resultatDAO.php";
class ExerciceService{
    private ExerciceDAO $exercice_dao;
    private ResultatDAO $resultat_dao;

    public function __construct()
    {
        $this->exercice_dao = new ExerciceDAO();
        $this->resultat_dao = new ResultatDAO();
    }
    /**
     * netoyer les donnees
     * Nettoyer les données en retirant les espaces inutiles.
     * htmlspecialchars est retiré car il doit être appliqué à l'affichage (output)
     * et non avant l'enregistrement en base de données pour éviter les problèmes de double encodage.
     * La protection contre les injections SQL doit être gérée par les requêtes préparées dans la couche DAO.
     */
    private function cleanData($data){
        return htmlspecialchars(trim($data));
        return trim($data);
    }
    //create and update data
    public function ajouterExercice(Exercice $exercice){
        $exercice->setIdLecon($this->cleanData($exercice->getIdLecon()));
        $exercice->setQuestion($this->cleanData($exercice->getQuestion()));
        $exercice->setType($this->cleanData($exercice->getType()));
        $exercice->setNiveau($this->cleanData($exercice->getNiveau()));
        $exercice->setScore($this->cleanData($exercice->getScore()));

        //verifier les donnees
        if(empty($exercice->getIdLecon()) || empty($exercice->getQuestion()) || empty($exercice->getType()) || empty($exercice->getNiveau()) || empty($exercice->getScore())){
        // La vérification pour le score utilise is_null pour autoriseir un score de 0.
        if(empty($exercice->getIdLecon()) || empty($exercice->getQueston()) || empty($exercice->getType()) || empty($exercice->getNiveau()) || is_null($exercice->getScore())){
            throw new Exception("Tous les champs sont obligatoires");
        }

        if($exercice->getIdExercice()){
            return $this->exercice_dao->UpdateExercice($exercice);
        }
        return $this->exercice_dao->AjouterExercice($exercice);
    }
    /**
     * afficher un exercice
     */
    public function afficherUnExercice($id_exercice){
        return $this->exercice_dao->getOneExercice($id_exercice);
    }
    /**
     * supprimer un exercice
     */
    public function supprimerExercice($id_exercice){
        return $this->exercice_dao->deleteExercice($id_exercice);
    }
    /**
     * afficher toutes les exercices
     */
    public function afficherToutesLesExercices(){
        return $this->exercice_dao->getAllExercice();
    }
    
    
    /*
      corriger l'exercice
      comparer la reponse de l'utilisateur avec la bonne reponse
     
    public function corrigerExercice($id_exercice,$id_utilisateur,$bonneReponse){
        //requiperer l'exercice
        $exercice = $this->exercice_dao->getOneExercice($id_exercice);
        if(!$exercice){
            throw new Exception("Exercice non trouve");
        }

        //comparer la reponse de l'utilisateur avec pa bonne repinse
        $estCorrect = trim(strtolower($bonneReponse)) === trim(strtolower($exercice->getBonneReponse));
        //enregistrer le resulat ...

        $resultat = new Resultat(
            null,
            $id_utilisateur,
            $id_exercice,
            $score,
            $estCorrect ? 1:0
        );

        $this->resultat_dao->CreateResultat($resultat);

        return $estCorrect;
        
    }*/
}



}







?>