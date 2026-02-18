<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\academique\Cours;
use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require_once __DIR__ . "../../../config/Database.php";
//require_once __DIR__ ."../../../model/Academique/cours.php";

// Note: The rest of the CoursDAO.php file is not provided in the snippets for comparison.
class CoursDAO{
    private static $bd;

    //etablir connexion a la bd
   public function __construct()
   {
        $pdo = new Database();
        self::$bd = $pdo->getConnexion();
   }
    //Ajouter un cours
    public static function CreateCours(Cours $cours){
       try{
         $requette = "INSERT INTO cours(titre,description,idMatiere,idProgramme,idClasse,statut,ordre_progression,niveau_difficulte,duree_estimee,date_creation,modification,type_cours,objectif_apprentissage,prerequis,ressources_externes,nb_vues,taux_reussite,seuil_reussite,createur_id,visible,tags) VALUES(:titre,:description,:idMatiere,:idProgramme,:idClasse,:statut,:ordre_progression,:niveau_difficulte,:duree_estimee,:date_creation,:modification,:type_cours,:objectif_apprentissage,:prerequis,:ressources_externes,:nb_vues,:taux_reussite,:seuil_reussite,:createur_id,:visible,:tags)";
        $stmt = self::$bd->prepare($requette);
                    return  $stmt->execute(
                                [
                                    ":titre" =>$cours->getTitre(),
                                    ":description" =>$cours->getDescription(),
                                    ":id_matiere" =>$cours->getIdMatiere(),
                                    ":id_programme" =>$cours->getIdProgramme(),
                                    ":id_classe" =>$cours->getIdClasse(),
                                    ":statut" =>$cours->getStatut(),
                                    ":ordre_progression" =>$cours->getOrdreProgression(),
                                    ":niveau_difficulte" =>$cours->getNiveauDifficulte(),
                                    ":duree_estimee" =>$cours->getDureeEstimee(),
                                    ":type_cours" =>$cours->getTypeCours(),
                                    ":objectif_apprentissage" =>$cours->getObjectifApprentissage(),
                                    ":prerequis" =>$cours->getPrerequis(),
                                    ":ressources_externes" =>$cours->getRessourcesExternes(),
                                    ":nb_vues" =>$cours->getNbVues(),
                                    ":taux_reussite" =>$cours->getTauxReussite(),
                                    ":seuil_reussite" =>$cours->getSeuilReussite(),
                                    ":createur_id" =>$cours->getCreateurId(),
                                    ":visible" =>$cours->getVisible(),
                                    
                                ]);
     
       } catch(PDOException $e){
        echo "Erreur : insertion a echoue" .$e->getMessage();

       }                      
    }

    //Afficher un cours
    public static function ReadCours($idCours){
        try{
            $sql = "SELECT * FROM cours";
            $stmt = self::$bd->prepare($sql);
            $stmt->execute([":idCours" => $idCours]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                return new Cours(
                    $row['idCours'],
                    $row['titre'],
                    $row['description'],
                    $row['id_matiere'],
                    $row['id_programme'],
                    $row['id_classe'],
                    $row['statut'],
                    $row['ordre_progression'],
                    $row['niveau_difficulte'],
                    $row['duree_estimee'],
                    $row['date_creation'],
                    $row['modification'],
                    $row['type_cours'],
                    $row['objectif_apprentissage'],
                    $row['prerequis'],
                    $row['ressources_externes'],
                    $row['nb_vues'],
                    $row['taux_reussite'],
                    $row['seuil_reussite'],
                    $row['createur_id'],
                    $row['visible'],
                    $row['tags']
                );
            }
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
            }
    }


    //Update cours
    public static function UpdateCours(Cours $cours){
        try{
            $sql = "UPDATE cours SET 
                    titre = :titre,
                    description = :description,
                    idMatiere = :idMatiere,
                    idProgramme = :idProgramme,
                    idClasse = :idClasse,
                    statut = :statut,
                    ordre_progression = :ordre_progression,
                    niveau_difficulte = :niveau_difficulte,
                    duree_estimee = :duree_estimee,
                    date_creation = :date_creation,
                    modification = :modification,
                    type_cours = :type_cours,
                    objectif_apprentissage = :objectif_apprentissage,
                    prerequis = :prerequis,
                    ressources_externes = :ressources_externes,
                    nb_vues = :nb_vues,
                    taux_reussite = :taux_reussite,
                    seuil_reussite = :seuil_reussite,
                    createur_id = :createur_id,
                    visible = :visible,
                    tags = :tags
                WHERE idCours = :idCours";
        $stmt = self::$bd->prepare($sql);
        return $stmt->execute([
            
            ":titre" =>$cours->getTitre(),
            ":description" =>$cours->getDescription(),
            ":idMatiere" =>$cours->getIdMatiere(),
            ":idProgramme" =>$cours->getIdProgramme(),
            ":idClasse" =>$cours->getIdClasse(),
            ":statut" =>$cours->getStatut(),
            ":ordre_progression" =>$cours->getOrdreProgression(),
            ":niveau_difficulte" =>$cours->getNiveauDifficulte(),
            ":duree_estimee" =>$cours->getDureeEstimee(),
            ":type_cours" =>$cours->getTypeCours(),
            ":objectif_apprentissage" =>$cours->getObjectifApprentissage(),
            ":prerequis" =>$cours->getPrerequis(),
            ":ressources_externes" =>$cours->getRessourcesExternes(),
            ":nb_vues" =>$cours->getNbVues(),
            ":taux_reussite" =>$cours->getTauxReussite(),
            ":seuil_reussite" =>$cours->getSeuilReussite(),
            ":createur_id" =>$cours->getCreateurId(),
        ]);
        }catch(PDOException $e){
            echo "Erreur : modification a echoue" .$e->getMessage();
        }
    }
    //Afficher tous les cours
    public static function  AfficherAllCours(){
        try{
            $sql = "SELECT * FROM cours";
            $stmt = self::$bd->query($sql);
            $listeCours = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $listeCours [] = new Cours(
                    $row['idCours'],
                    $row['titre'],
                    $row['description'],
                    $row['id_matiere'],
                    $row['id_programme'],
                    $row['id_classe'],
                    $row['statut'], 
                    $row['ordre_progression'],
                    $row['niveau_difficulte'],
                    $row['duree_estimee'],  
                    $row['date_creation'],
                    $row['modification'],
                    $row['type_cours'],
                    $row['objectif_apprentissage'],
                    $row['prerequis'],
                    $row['ressources_externes'],
                    $row['nb_vues'],
                    $row['taux_reuissite'],
                    $row['seuil_reussite'],
                    $row['createur_id'],
                    $row['visible'],
                    $row['tags']
                );
            }
            return $listeCours;
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    
    //Delete cours
    public static function DeleteCours($id_cours){
        try{
            $sql = "DELETE FROM cours WHERE id_cours = :id_cours";
            $stmt = self::$bd->prepare($sql);
            $stmt->bindValue("id_cours",$id_cours);
            return $stmt->execute([":id_cours" => $id_cours]);
        }catch(PDOException $e){
            echo "Erreur : suppression a echoue" .$e->getMessage();

        }
    }

}



?>