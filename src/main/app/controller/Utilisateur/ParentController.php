<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../../service/Utilisateur/ParentService.php";

class ParentController
{
    private ParentService $parentService;

    public function __construct()
    {
        $this->parentService = new ParentService();
    }

    // Tableau de bord du parent
    public function dashboard()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PARENT) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $parentId = $_SESSION['user_id'];
        $enfants = $this->parentService->getEnfants($parentId);
        $notifications = $this->parentService->getNotifications($parentId);
        
        require __DIR__ . "/../../views/parent/dashboard.php";
    }

    // Voir les notes des enfants
    public function voirNotes()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PARENT) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $parentId = $_SESSION['user_id'];
        $enfantId = $_GET['enfant_id'] ?? null;
        
        if (!$enfantId || !$this->parentService->estParentDe($parentId, $enfantId)) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $notes = $this->parentService->getNotesEnfant($enfantId);
        $enfant = $this->parentService->getEnfantInfo($enfantId);
        
        require __DIR__ . "/../../views/parent/notes.php";
    }

    // Voir les absences des enfants
    public function voirAbsences()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PARENT) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $parentId = $_SESSION['user_id'];
        $enfantId = $_GET['enfant_id'] ?? null;
        
        if (!$enfantId || !$this->parentService->estParentDe($parentId, $enfantId)) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $absences = $this->parentService->getAbsencesEnfant($enfantId);
        $enfant = $this->parentService->getEnfantInfo($enfantId);
        
        require __DIR__ . "/../../views/parent/absences.php";
    }

    // Contacter un enseignant
    public function contacterEnseignant()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PARENT) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parentId = $_SESSION['user_id'];
            $enseignantId = $_POST['enseignant_id'];
            $sujet = $_POST['sujet'];
            $message = $_POST['message'];
            
            $this->parentService->envoyerMessage($parentId, $enseignantId, $sujet, $message);
            
            $_SESSION['success'] = "Message envoyé avec succès";
            header("Location: /parent/messages");
            exit;
        }
        
        $enseignants = $this->parentService->getEnseignantsEnfants($_SESSION['user_id']);
        require __DIR__ . "/../../views/parent/contact_enseignant.php";
    }

    // Voir les emplois du temps des enfants
    public function voirEmploiDuTemps()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PARENT) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $parentId = $_SESSION['user_id'];
        $enfantId = $_GET['enfant_id'] ?? null;
        
        if (!$enfantId || !$this->parentService->estParentDe($parentId, $enfantId)) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $emploiDuTemps = $this->parentService->getEmploiDuTempsEnfant($enfantId);
        $enfant = $this->parentService->getEnfantInfo($enfantId);
        
        require __DIR__ . "/../../views/parent/emploi_du_temps.php";
    }

    // Participer aux réunions
    public function reunions()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PARENT) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        $parentId = $_SESSION['user_id'];
        $reunions = $this->parentService->getReunions($parentId);
        
        require __DIR__ . "/../../views/parent/reunions.php";
    }

    // Mettre à jour le profil
    public function modifierProfil()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PARENT) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès interdit');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parentId = $_SESSION['user_id'];
            $data = [
                'telephone' => $_POST['telephone'],
                'adresse' => $_POST['adresse'],
                'profession' => $_POST['profession']
            ];
            
            $this->parentService->updateProfil($parentId, $data);
            
            $_SESSION['success'] = "Profil mis à jour avec succès";
            header("Location: /parent/profil");
            exit;
        }
        
        $parent = $this->parentService->getParentInfo($_SESSION['user_id']);
        require __DIR__ . "/../../views/parent/modifier_profil.php";
    }
}
?>
