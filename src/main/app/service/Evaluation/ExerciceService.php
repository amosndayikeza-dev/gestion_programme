<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Evaluation/ExerciceDAO.php";
require_once __DIR__ ."../../../dao/Evaluation/resultatDAO.php";
class ExerciceService{
    private ExerciceDAO $exercice_dao;
    private resultatDAO $resultat_dao;

    public function __construct()
    {
        $exercice_dao = new ExerciceDAO();
        $resultat_dao = new ResultatDAO();
    }
    /**
     * corriger l'exercice
     * comparer la reponse de l'utilisateur avec la bonne reponse
     */
    public function corrigerExercice($id_exercice,$id_utilisateur,$bonneReponse){
        //requiperer l'exercice
        $exercice = $this->exercice_dao->getOneExercice($id_exercice);
        if(!$exercice){
            throw new Exception("Exercice non trouve");
        }

        //comparer la reponse de l'utilisateur avec pa bonne repinse
        $estCorrect = trim(strtolower($bonneReponse)) === trim(strtolower($exercice->getBonneReponse));
        //enregistrer le resulat

        $resultat = new Resultat(
            null,
            $id_utilisateur,
            $id_exercice,
            $score,
            $estCorrect ? 1:0
        );

        $this->resultat_dao->CreateResultat($resultat);

        return $estCorrect;
        
    }
}











?>