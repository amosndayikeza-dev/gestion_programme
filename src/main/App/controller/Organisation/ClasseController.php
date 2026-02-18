<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/Organisation/ClasseService.php";

class ClasseController{
    private ClasseService $classe_service;

    public function __construct()
    {
        $this->classe_service = new ClasseService();
    }

    public function traitementFormulaireClasse(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //recuperer les donnees du formulaire
            $nom_classe = $_POST['nom_classe'];
            $niveau = $_POST['niveau'];
            $id_etablissement = $_POST['id_etablissement'];
            $description = $_POST['description'];
            $effectif_max = $_POST['effectif_max'];
            $salle = $_POST['salle'];
            $effectif_actuel = $_POST['effectif_actuel'];
            $annnee_scolaire = $_POST['annnee_scolaire'];

            //creer l'obdjet
            $classe = new Classe();
            if(!empty($_POST['id_classe'])){
                $classe->setIdClasse($_POST['id_classe']);
            }
            $classe->setNomClasse($nom_classe);
            $classe->setNiveau($niveau);
            $classe->setIdEtablissement($id_etablissement);
            $classe->setDescription($description);
            $classe->setEffectifMaximal($effectif_max);
            $classe->setSalle($salle);
            $classe->setEffectifActuel($effectif_actuel);
            $classe->setAnneeScolaire($annnee_scolaire);
            //appeler un service
            $success = $this->classe_service->createClasse($classe);
            if($success){
                header("location: /classe");
            }else{
                header("location: /classe");    
        }
        }else{
        require __DIR__ ."/../../views/classe/creer.php";
        }
    }
    

    //afficher une classe
    public function afficherClasse($id_classe){
        $classe = $this->classe_service->afficherClasse($id_classe);
        require __DIR__ ."/../../views/classe/detail.php";
    }
    //afficher totes les classes
    public function afficherToutesLesClasses(){
        $classes = $this->classe_service->afficherToutesLesClasses();
        require __DIR__ ."/../../views/classe/liste.php";
    }
    //supprimer une classe
    public function supprimerClasse($id_classe){
        $this->classe_service->supprimerClasse($id_classe);
        header("location: /classe");
        exit;
    }




}











?>