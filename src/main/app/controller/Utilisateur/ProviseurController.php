<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../../service/Utilisateur/ProviseurService.php";

class ProviseurController
{
    private ProviseurService $proviseurService;

    public function __construct()
    {
        $this->proviseurService = new ProviseurService();
    }

    // Tableau de bord du proviseur
    public function dashboard()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $proviseurId = $_SESSION['user_id'];
        $statistiques = $this->proviseurService->getStatistiquesEtablissement();
        $notifications = $this->proviseurService->getNotificationsUrgentes();
        $evenements = $this->proviseurService->getEvenementsAvenir();
        
        require __DIR__ . "/../../views/proviseur/dashboard.php";
    }

    // Gérer le personnel
    public function gererPersonnel()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $personnel = $this->proviseurService->getAllPersonnel();
        
        require __DIR__ . "/../../views/proviseur/personnel.php";
    }

    // Ajouter un membre du personnel
    public function ajouterPersonnel()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proviseurId = $_SESSION['user_id'];
            $data = [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'role' => $_POST['role'],
                'telephone' => $_POST['telephone'] ?? null,
                'specialite' => $_POST['specialite'] ?? null
            ];
            
            $this->proviseurService->ajouterPersonnel($proviseurId, $data);
            
            $_SESSION['success'] = "Personnel ajouté avec succès";
            header("Location: /proviseur/personnel");
            exit;
        }
        
        $roles = $this->proviseurService->getRolesDisponibles();
        
        require __DIR__ . "/../../views/proviseur/ajouter_personnel.php";
    }

    // Gérer les élèves
    public function gererEleves()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $eleves = $this->proviseurService->getAllEleves();
        $classes = $this->proviseurService->getAllClasses();
        
        require __DIR__ . "/../../views/proviseur/eleves.php";
    }

    // Voir tous les rapports
    public function rapports()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $type = $_GET['type'] ?? 'tous';
        $periode = $_GET['periode'] ?? 'mois';
        
        $rapports = $this->proviseurService->getRapports($type, $periode);
        
        require __DIR__ . "/../../views/proviseur/rapports.php";
    }

    // Gérer le budget
    public function budget()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proviseurId = $_SESSION['user_id'];
            $data = [
                'type_operation' => $_POST['type_operation'],
                'montant' => $_POST['montant'],
                'description' => $_POST['description'],
                'categorie' => $_POST['categorie'],
                'date' => $_POST['date']
            ];
            
            $this->proviseurService->enregistrerOperationBudget($proviseurId, $data);
            
            $_SESSION['success'] = "Opération budgétaire enregistrée";
            header("Location: /proviseur/budget");
            exit;
        }
        
        $budget = $this->proviseurService->getSituationBudget();
        $operations = $this->proviseurService->getOperationsBudget();
        
        require __DIR__ . "/../../views/proviseur/budget.php";
    }

    // Organiser des événements
    public function organiserEvenement()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proviseurId = $_SESSION['user_id'];
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'date' => $_POST['date'],
                'lieu' => $_POST['lieu'],
                'type' => $_POST['type'],
                'participants' => $_POST['participants'] ?? [],
                'budget' => $_POST['budget'] ?? null
            ];
            
            $this->proviseurService->organiserEvenement($proviseurId, $data);
            
            $_SESSION['success'] = "Événement organisé avec succès";
            header("Location: /proviseur/evenements");
            exit;
        }
        
        require __DIR__ . "/../../views/proviseur/organiser_evenement.php";
    }

    // Voir les événements
    public function evenements()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $evenements = $this->proviseurService->getEvenements();
        
        require __DIR__ . "/../../views/proviseur/evenements.php";
    }

    // Représenter l'établissement
    public function representation()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $representations = $this->proviseurService->getRepresentations();
        $demandes = $this->proviseurService->getDemandesRepresentation();
        
        require __DIR__ . "/../../views/proviseur/representation.php";
    }

    // Validations
    public function validations()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proviseurId = $_SESSION['user_id'];
            $data = [
                'demande_id' => $_POST['demande_id'],
                'decision' => $_POST['decision'],
                'commentaire' => $_POST['commentaire'] ?? null
            ];
            
            $this->proviseurService->validerDecision($proviseurId, $data);
            
            $_SESSION['success'] = "Décision enregistrée avec succès";
            header("Location: /proviseur/validations");
            exit;
        }
        
        $demandes = $this->proviseurService->getDemandesValidation();
        
        require __DIR__ . "/../../views/proviseur/validations.php";
    }

    // Paramètres de l'établissement
    public function parametres()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PROVISEUR) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proviseurId = $_SESSION['user_id'];
            $data = [
                'nom_etablissement' => $_POST['nom_etablissement'],
                'adresse' => $_POST['adresse'],
                'telephone' => $_POST['telephone'],
                'email' => $_POST['email'],
                'annee_scolaire' => $_POST['annee_scolaire']
            ];
            
            $this->proviseurService->updateParametres($proviseurId, $data);
            
            $_SESSION['success'] = "Paramètres mis à jour avec succès";
            header("Location: /proviseur/parametres");
            exit;
        }
        
        $parametres = $this->proviseurService->getParametres();
        
        require __DIR__ . "/../../views/proviseur/parametres.php";
    }
}
?>
