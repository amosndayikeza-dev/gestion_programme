<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../config/Database.php";
require_once __DIR__ ."../../model/cours.php";

// Note: The rest of the CoursDAO.php file is not provided in the snippets for comparison.
class CoursDAO{
    private static $bd;

    //etablir connexion a la bd
    public static function EtablirConnexion(){
        $pdo = new Database();
        while(self::$bd = $pdo->getConnexion()){
            echo "connexion etablie";
            exit;
        }
    }
    //Ajouter un cours
    public static function Create(Cours $cours){
        $requette = "INSERT INTO cours(titre,description,idMatiere,idProgramme,idClasse,statut,ordre_progression,niveau_difficulte,duree_estimee,date_creation,modification,type_cours,objectif_apprentissage,prerequis,ressources_externes,nb_vues,taux_reussite,seuil_reussite,createur_id,visible,tags) ;
                    VALUES(:titre,:description,:idMatiere,:idProgramme,:idClasse,:statut,:ordre_progression,:niveau_difficulte,:duree_estimee,:date_creation,:modification,:type_cours,:objectif_apprentissage,:prerequis,:ressources_externes,:nb_vues,:taux_reussite,:seuil_reussite,:createur_id,:visible,:tags)";
                    $stmt = self::$bd->prepare($requette);
                    return  $stmt->execute(
                                [
                                    ":titre" =>$cours->getTitre(),
                                    ":description" =>$cours->getDescription(),
                                    ":idMatiere" =>$cours->getIdMatiere(),
                                    ":idProgramme" =>$cours->getIdProgramme(),
                                    ":idClasse" =>$cours->getIdClasse(),
                                    ":statut" =>$cours->getStatut(),
                                    ":ordre_progression" =>$cours->getOrdreProgression(),
                                    ":niveau_difficulte" =>$cours->getNiveauDifficulte(),
                                    ":duree_estimee" =>$cours->getDureeEstimee(),
                                    ":date_creation" =>$cours->getDateCreation(),
                                    ":modification" =>$cours->getModification(),
                                    ":type_cours" =>$cours->getTypeCours(),
                                    ":objectif_apprentissage" =>$cours->getObjectifApprentissage(),
                                    ":prerequis" =>$cours->getPrerequis(),
                                    ":ressources_externes" =>$cours->getRessourcesExternes(),
                                    ":nb_vues" =>$cours->getNbVues(),
                                    ":taux_reussite" =>$cours->getTauxReussite(),
                                    ":seuil_reussite" =>$cours->getSeuilReussite(),
                                    ":createur_id" =>$cours->getCreateurId(),
                                    ":visible" =>$cours->getVisible(),
                                    ":tags" =>$cours->getTags(),
                                ]
                            );
}


}



?>