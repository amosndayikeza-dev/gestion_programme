<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../../service/Utilisateur/DirecteurDisciplineService.php";

class DirecteurDisciplineController
{
    private DirecteurDisciplineService $directeurDisciplineService;

    public function __construct()
    {
        $this->directeurDisciplineService = new DirecteurDisciplineService();
    }

    // Tableau de bord du directeur de discipline
    public function dashboard()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $directeurId = $_SESSION['user_id'];
        $statistiques = $this->directeurDisciplineService->getStatistiques();
        $incidentsRecents = $this->directeurDisciplineService->getIncidentsRecents();
        $dossiersUrgents = $this->directeurDisciplineService->getDossiersUrgents();
        
        require __DIR__ . "/../../views/directeur_discipline/dashboard.php";
    }

    // Gérer les dossiers disciplinaires
    public function dossiersDisciplinaires()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $dossiers = $this->directeurDisciplineService->getAllDossiers();
        
        require __DIR__ . "/../../views/directeur_discipline/dossiers.php";
    }

    // Voir un dossier spécifique
    public function voirDossier()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $dossierId = $_GET['id'] ?? null;
        if (!$dossierId) {
            header('HTTP/1.0 400 Bad Request');
            exit('ID de dossier requis');
        }
        
        $dossier = $this->directeurDisciplineService->getDossier($dossierId);
        $sanctions = $this->directeurDisciplineService->getSanctionsDossier($dossierId);
        
        require __DIR__ . "/../../views/directeur_discipline/voir_dossier.php";
    }

    // Donner une sanction
    public function donnerSanction()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $directeurId = $_SESSION['user_id'];
            $data = [
                'eleve_id' => $_POST['eleve_id'],
                'type_sanction' => $_POST['type_sanction'],
                'motif' => $_POST['motif'],
                'duree' => $_POST['duree'] ?? null,
                'date_debut' => $_POST['date_debut'],
                'description' => $_POST['description']
            ];
            
            $this->directeurDisciplineService->donnerSanction($directeurId, $data);
            
            $_SESSION['success'] = "Sanction appliquée avec succès";
            header("Location: /directeur_discipline/dossiers");
            exit;
        }
        
        $eleves = $this->directeurDisciplineService->getAllEleves();
        $typesSanctions = $this->directeurDisciplineService->getTypesSanctions();
        
        require __DIR__ . "/../../views/directeur_discipline/donner_sanction.php";
    }

    // Organiser un conseil de discipline
    public function conseilDiscipline()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $directeurId = $_SESSION['user_id'];
            $data = [
                'eleve_id' => $_POST['eleve_id'],
                'date_conseil' => $_POST['date_conseil'],
                'heure' => $_POST['heure'],
                'lieu' => $_POST['lieu'],
                'motif' => $_POST['motif'],
                'membres_invites' => $_POST['membres_invites'] ?? []
            ];
            
            $this->directeurDisciplineService->organiserConseil($directeurId, $data);
            
            $_SESSION['success'] = "Conseil de discipline programmé avec succès";
            header("Location: /directeur_discipline/conseils");
            exit;
        }
        
        $eleves = $this->directeurDisciplineService->getAllEleves();
        $enseignants = $this->directeurDisciplineService->getEnseignants();
        
        require __DIR__ . "/../../views/directeur_discipline/conseil_discipline.php";
    }

    // Voir les conseils de discipline
    public function conseils()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $conseils = $this->directeurDisciplineService->getConseils();
        
        require __DIR__ . "/../../views/directeur_discipline/conseils.php";
    }

    // Exclure un élève
    public function exclureEleve()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $directeurId = $_SESSION['user_id'];
            $data = [
                'eleve_id' => $_POST['eleve_id'],
                'type_exclusion' => $_POST['type_exclusion'],
                'duree' => $_POST['duree'],
                'motif' => $_POST['motif'],
                'date_debut' => $_POST['date_debut'],
                'conditions_retour' => $_POST['conditions_retour']
            ];
            
            $this->directeurDisciplineService->exclureEleve($directeurId, $data);
            
            $_SESSION['success'] = "Exclusion enregistrée avec succès";
            header("Location: /directeur_discipline/exclusions");
            exit;
        }
        
        $eleves = $this->directeurDisciplineService->getAllEleves();
        
        require __DIR__ . "/../../views/directeur_discipline/exclure_eleve.php";
    }

    // Voir les exclusions
    public function exclusions()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $exclusions = $this->directeurDisciplineService->getExclusions();
        
        require __DIR__ . "/../../views/directeur_discipline/exclusions.php";
    }

    // Rapports de discipline
    public function rapports()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $periode = $_GET['periode'] ?? 'mois';
        $rapports = $this->directeurDisciplineService->getRapports($periode);
        
        require __DIR__ . "/../../views/directeur_discipline/rapports.php";
    }

    // Plages de disponibilité
    public function plagesDisponibilite()
    {
        if ($_SESSION['user_role'] !== RoleEnum::DIRECTEUR_DISCIPLINE) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $directeurId = $_SESSION['user_id'];
            $plages = $_POST['plages'] ?? [];
            
            $this->directeurDisciplineService->updatePlagesDisponibilite($directeurId, $plages);
            
            $_SESSION['success'] = "Plages de disponibilité mises à jour";
            header("Location: /directeur_discipline/disponibilite");
            exit;
        }
        
        $plages = $this->directeurDisciplineService->getPlagesDisponibilite($_SESSION['user_id']);
        
        require __DIR__ . "/../../views/directeur_discipline/plages_disponibilite.php";
    }
}
?>
