<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../../service/Utilisateur/PrefetService.php";

class PrefetController
{
    private PrefetService $prefetService;

    public function __construct()
    {
        $this->prefetService = new PrefetService();
    }

    // Tableau de bord du préfet
    public function dashboard()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $prefetId = $_SESSION['user_id'];
        $classeSurveillee = $this->prefetService->getClasseSurveillee($prefetId);
        $problemesSignales = $this->prefetService->getProblemesSignales($prefetId);
        $notifications = $this->prefetService->getNotifications($prefetId);
        
        require __DIR__ . "/../../views/prefet/dashboard.php";
    }

    // Signaler un problème
    public function signalerProbleme()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prefetId = $_SESSION['user_id'];
            $data = [
                'type' => $_POST['type'],
                'description' => $_POST['description'],
                'eleve_concerne' => $_POST['eleve_concerne'] ?? null,
                'urgence' => $_POST['urgence']
            ];
            
            $this->prefetService->signalerProbleme($prefetId, $data);
            
            $_SESSION['success'] = "Problème signalé avec succès";
            header("Location: /prefet/dashboard");
            exit;
        }
        
        $elevesClasse = $this->prefetService->getElevesClasse($_SESSION['user_id']);
        require __DIR__ . "/../../views/prefet/signaler_probleme.php";
    }

    // Gérer la discipline de la classe
    public function gererDiscipline()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $prefetId = $_SESSION['user_id'];
        $incidents = $this->prefetService->getIncidentsClasse($prefetId);
        $eleves = $this->prefetService->getElevesClasse($prefetId);
        
        require __DIR__ . "/../../views/prefet/discipline.php";
    }

    // Donner une sanction mineure
    public function donnerSanction()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prefetId = $_SESSION['user_id'];
            $data = [
                'eleve_id' => $_POST['eleve_id'],
                'type_sanction' => $_POST['type_sanction'],
                'motif' => $_POST['motif'],
                'duree' => $_POST['duree'] ?? null
            ];
            
            if ($this->prefetService->peutDonnerSanction($prefetId)) {
                $this->prefetService->donnerSanction($prefetId, $data);
                $_SESSION['success'] = "Sanction enregistrée avec succès";
            } else {
                $_SESSION['error'] = "Vous n'avez pas l'autorisation de donner cette sanction";
            }
            
            header("Location: /prefet/discipline");
            exit;
        }
        
        $eleves = $this->prefetService->getElevesClasse($_SESSION['user_id']);
        require __DIR__ . "/../../views/prefet/donner_sanction.php";
    }

    // Organiser une activité de classe
    public function organiserActivite()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prefetId = $_SESSION['user_id'];
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'date' => $_POST['date'],
                'lieu' => $_POST['lieu'],
                'type' => $_POST['type']
            ];
            
            $this->prefetService->proposerActivite($prefetId, $data);
            
            $_SESSION['success'] = "Activité proposée avec succès";
            header("Location: /prefet/activites");
            exit;
        }
        
        require __DIR__ . "/../../views/prefet/organiser_activite.php";
    }

    // Voir les activités proposées
    public function activites()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $prefetId = $_SESSION['user_id'];
        $activites = $this->prefetService->getActivites($prefetId);
        
        require __DIR__ . "/../../views/prefet/activites.php";
    }

    // Représenter la classe
    public function representeClasse()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $prefetId = $_SESSION['user_id'];
        $reunions = $this->prefetService->getReunions($prefetId);
        $propositions = $this->prefetService->getPropositions($prefetId);
        
        require __DIR__ . "/../../views/prefet/representation.php";
    }

    // Rapport hebdomadaire
    public function rapportHebdomadaire()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prefetId = $_SESSION['user_id'];
            $data = [
                'semaine' => $_POST['semaine'],
                'contenu' => $_POST['contenu'],
                'incidents' => $_POST['incidents'],
                'observations' => $_POST['observations']
            ];
            
            $this->prefetService->soumettreRapport($prefetId, $data);
            
            $_SESSION['success'] = "Rapport soumis avec succès";
            header("Location: /prefet/rapports");
            exit;
        }
        
        require __DIR__ . "/../../views/prefet/rapport_hebdomadaire.php";
    }
}
?>
