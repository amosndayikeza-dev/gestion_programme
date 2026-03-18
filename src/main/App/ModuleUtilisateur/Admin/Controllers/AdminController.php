<?php
namespace App\ModuleUtilisateur\Admin\Controllers;

use App\core\Config\Controller;
use App\ModuleUtilisateur\Models\Administrateur;
use App\ModuleUtilisateur\Admin\Services\AdminService;
use Exception;

// controlleur pour la gestion des administrateurs
class AdminCnotroller extends Controller{

/**
 * @var AdminService
 */

private $adminService;

public function __construct(){
    parent::__construct();
    $this->adminService = new AdminService();
}

// aficher la liste des administrateurs
public function index(){
    $admins = $this->adminService->getAllAdmins();

    $this->checkAccess('administrateur');

    $admin = $this->adminService->getAllAdmins();
    $this->render('admin/index',['admins' => $admins]);

    //afficher le formulaire de creation 
    
    
}

public function create(){
        $this->checkAccess('administrateur');
        $this->render('admin/form');
}
/**
 * Traiter la creation d'un administarteur
 */

public function store(){
    $this->checkAccess('administrateur');

    $data = $_POST;
    $errors = $this->adminService->validate($data);

    if(!empty($error)){
       $this->setFlash('error',$errors);
       $this->setFlash('old',$data);
       $this->redirect("/admin/create");

       return;
    }

    $admin = $this->adminService->createAdmin($data);
    if($admin){
        $this->setFlash('success', "Administrateur créé avec succès.");
        $this->redirect('/admin');
    }else{
        $this->setFlash('error', "Erreur lors de la création.");
        $this->redirect('/admin/create');
    }

}
    /**
     * Affiche le formulaire d'édition
     * @param int $id
     */
    public function edit(int $id)
    {
        $this->checkAccess('administrateur');

        $admin = $this->adminService->getAdminById($id);
        if (!$admin) {
            $this->setFlash('error', "Administrateur introuvable.");
            $this->redirect('/admin');
            return;
        }

        $this->render('admin/form', ['admin' => $admin]);
    }

    /**
     * Traite la modification d'un administrateur
     * @param int $id
     */
    public function update(int $id)
    {
        $this->checkAccess('administrateur');

        $data = $_POST;
        $errors = $this->adminService->validate($data, $id);

        if (!empty($errors)) {
            $this->setFlash('errors', $errors);
            $this->setFlash('old', $data);
            $this->redirect("/admin/edit/$id");
            return;
        }

        if ($this->adminService->updateAdmin($id, $data)) {
            $this->setFlash('success', "Administrateur mis à jour.");
            $this->redirect('/admin');
        } else {
            $this->setFlash('error', "Erreur lors de la mise à jour.");
            $this->redirect("/admin/edit/$id");
        }
    }

    /**
     * Supprime un administrateur
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->checkAccess('administrateur');

        if ($this->adminService->deleteAdmin($id)) {
            $this->setFlash('success', "Administrateur supprimé.");
        } else {
            $this->setFlash('error', "Erreur lors de la suppression.");
        }
        $this->redirect('/admin');
    }

    /**
     * Vérifie que l'utilisateur connecté a le rôle requis
     * @param string $role
     */
    private function checkAccess(string $role): void
    {
        if (!$this->isAuthentificated() || ($_SESSION['user_role'] ?? null) !== $role) {
            $this->setFlash('error', "Accès non autorisé.");
            $this->redirect('/login');
        }
    }
}


?>