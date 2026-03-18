<?php
namespace App\ModuleUtilisateur\DirecteurDiscipline\Controllers;

use App\Config\Database;
use App\Core\Config\Controller;
use App\ModuleUtilisateur\DecteurDiscipline\Services\DirecteurDisciplineService as ServicesDirecteurDisciplineService;
use App\ModuleUtilisateur\DirecteurDiscipline\Services\DirecteurDisciplineService;
use App\ModuleUtilisateur\DirecteurDiscipline\Models\DirecteurDiscipline;

/**
 *  Les controllers pour les direecteurs de dscipline
 */

class DirecteurDisciplineController extends Controller{
    private $directeurdisciplineService;

    public function __construct()
    {
        return parent::__construct();
        $this->directeurdisciplineService = new ServicesDirecteurDisciplineService();

    }

    public function index(){
        $this->checkAccess('directeur_discipline');

        $directeurs = $this->directeurdisciplineService->getAll();
        $this->render('directeur_discipline/index',['directeurs' =>$directeurs]);
    }

    /**
     * Afficher le formulaire d'ajout du directeur
     */
    public function create(){
        $this->checkAccess('directeur_discipline');
        $this->render('directeur_discipline/form');

    }

    /**
     * Enregistrer un directeur de discipline
     */

    public function store(){
        $this->checkAccess('directeur_discipline');

        $data = $_POST;
        $error = $this->directeurdisciplineService->validate($data);
        if(!empty($error)){
            $this->setFlash('error',$error);
            $this->setFlash('old',$data);
            $this->redirect('/directeur_discipline/create');
            return;
        }

        $directeur = $this->directeurdisciplineService->create($data);
        if($directeur){
            $this->setFlash('success','Directeur de discipline créé avec succès.');
            $this->redirect('/directeur_discipline');
        }else{
            $this->setFlash('error','Erreur lors de la création du directeur de discipline.');
            $this->redirect('/directeur_discipline/create');
        }

    }

    /**
     *  Editer un directeur
     */
    public function edit(int $id){
        $this->checkAccess('directeur_discipline');

        $directeur = $this->directeurdisciplineService->getById($id);
        if(!$directeur){
            $this->setFlash('error','Directeur de discipline introuvable.');
            $this->redirect('/directeur-discipline');
            return;
        }

        $this->render('directeur_discipline/form', ['directeur' => $directeur]);
    }

    // modifier un directeur
    public function update(int $id){
        $this->checkAccess('directeur_discipline');
        $data = $_POST;
        $error = $this->directeurdisciplineService->validate($data,$id);

        if(!empty($error)){
            $this->setFlash('error',$error);
            $this->setFlash('old',$data);
            $this->redirect('/directeur_discipline/edit/$id');
            return;
        }

        if($this->directeurdisciplineService->update($id,$data)){
            $this->setFlash('success','Directeur de discipline mis à jour avec succès.');
            $this->redirect('/directeur_discipline');
        }else{
            $this->setFlash('error','Erreur lors de la mise à jour du directeur de discipline.');
            $this->redirect('/directeur_discipline/edit/$id');
        }
    }

    /**
     * Supprimer un directeur
     */
    public function delete($id){
        $this->checkAccess('directeur_discipline');
        if($this->directeurdisciplineService->delete($id)){
            $this->setFlash('success','Directeur de discipline supprimé avec succès.');
        }else{
            $this->setFlash('error','Erreur lors de la suppression du directeur de discipline.');
        }
        $this->redirect('/directeur_discipline');
    }


    /**
     * verifier que l'utilisateur est un directeur de discipline
     */

    private function checkAccess($role){
        if(!$this->isAuthentificated() || ($_SESSION['user_role'] ?? null) !== $role){
            $this->setFlash('error','Accès non autorisé.');
            $this->redirect('/login');
        }
    }
    
}



?>