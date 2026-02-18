<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../../service/Organisation/ClasseService.php";
require_once __DIR__ . "../../../model/Organisation/Classe.php";
require_once __DIR__ . "../../../model/Utilisateur/RoleEnum.php";

class PrefetEtudesController
{
    private ClasseService $classeService;

    public function __construct()
    {
        $this->classeService = new ClasseService();
    }

    /**
     * Tableau de bord du préfet des études
     */
    public function dashboard()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès réservé au préfet des études');
        }
        
        $prefetId = $_SESSION['user_id'];
        $statistiques = $this->classeService->getStatistiquesClasses();
        $classesRecentes = $this->classeService->getClassesRecentes();
        $propositionsEnAttente = $this->classeService->getPropositionsEnAttente();
        
        require __DIR__ . "/../../views/prefet_etudes/dashboard.php";
    }

    /**
     * Formulaire pour ajouter une classe
     */
    public function ajouterClasse()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès réservé au préfet des études');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prefetId = $_SESSION['user_id'];
            
            $classe = new Classe(
                null, // idClasse (auto-généré)
                $_POST['nom_classe'],
                $_POST['niveau'],
                $_POST['cycle'],
                $_POST['id_option'] ?? null,
                $_POST['id_section'] ?? null,
                $_POST['capacite'],
                $_POST['id_ecole'],
                $_POST['description'] ?? null,
                $_POST['effectif_maximal'] ?? null,
                0, // effectifActuel (initial)
                null, // salle (à définir plus tard)
                $_POST['annee_scolaire'] ?? null
            );
            
            try {
                $resultat = $this->classeService->ajouterClasse($classe, $prefetId);
                
                if ($resultat) {
                    $_SESSION['success'] = "Classe ajoutée avec succès";
                    header("Location: /prefet-etudes/classes");
                    exit;
                } else {
                    $_SESSION['error'] = "Erreur lors de l'ajout de la classe";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur : " . $e->getMessage();
            }
        }
        
        // Récupérer les données pour les formulaires déroulants
        $options = $this->classeService->getOptionsEtude();
        $sections = $this->classeService->getSections();
        $ecoles = $this->classeService->getEcoles();
        $anneesScolaires = $this->classeService->getAnneesScolaires();
        
        require __DIR__ . "/../../views/prefet_etudes/ajouter_classe.php";
    }

    /**
     * Liste de toutes les classes
     */
    public function listerClasses()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès réservé au préfet des études');
        }
        
        $filtres = [
            'niveau' => $_GET['niveau'] ?? null,
            'cycle' => $_GET['cycle'] ?? null,
            'id_option' => $_GET['id_option'] ?? null,
            'id_section' => $_GET['id_section'] ?? null,
            'id_ecole' => $_GET['id_ecole'] ?? null,
            'annee_scolaire' => $_GET['annee_scolaire'] ?? null
        ];
        
        $classes = $this->classeService->getClassesFiltrees($filtres);
        $options = $this->classeService->getOptionsEtude();
        $sections = $this->classeService->getSections();
        $ecoles = $this->classeService->getEcoles();
        $anneesScolaires = $this->classeService->getAnneesScolaires();
        
        require __DIR__ . "/../../views/prefet_etudes/lister_classes.php";
    }

    /**
     * Modifier une classe existante
     */
    public function modifierClasse()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès réservé au préfet des études');
        }
        
        $idClasse = $_GET['id'] ?? null;
        if (!$idClasse) {
            header('HTTP/1.0 400 Bad Request');
            exit('ID de classe requis');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prefetId = $_SESSION['user_id'];
            
            $classe = new Classe(
                $idClasse,
                $_POST['nom_classe'],
                $_POST['niveau'],
                $_POST['cycle'],
                $_POST['id_option'] ?? null,
                $_POST['id_section'] ?? null,
                $_POST['capacite'],
                $_POST['id_ecole'],
                $_POST['description'] ?? null,
                $_POST['effectif_maximal'] ?? null,
                $_POST['effectif_actuel'] ?? 0,
                $_POST['salle'] ?? null,
                $_POST['annee_scolaire'] ?? null
            );
            
            try {
                $resultat = $this->classeService->modifierClasse($classe, $prefetId);
                
                if ($resultat) {
                    $_SESSION['success'] = "Classe modifiée avec succès";
                    header("Location: /prefet-etudes/classes");
                    exit;
                } else {
                    $_SESSION['error'] = "Erreur lors de la modification de la classe";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur : " . $e->getMessage();
            }
        }
        
        $classe = $this->classeService->getClasseParId($idClasse);
        if (!$classe) {
            header('HTTP/1.0 404 Not Found');
            exit('Classe non trouvée');
        }
        
        $options = $this->classeService->getOptionsEtude();
        $sections = $this->classeService->getSections();
        $ecoles = $this->classeService->getEcoles();
        $anneesScolaires = $this->classeService->getAnneesScolaires();
        
        require __DIR__ . "/../../views/prefet_etudes/modifier_classe.php";
    }

    /**
     * Supprimer une classe
     */
    public function supprimerClasse()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès réservé au préfet des études');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            exit('Méthode non autorisée');
        }
        
        $idClasse = $_POST['id_classe'] ?? null;
        if (!$idClasse) {
            header('HTTP/1.0 400 Bad Request');
            exit('ID de classe requis');
        }
        
        try {
            $prefetId = $_SESSION['user_id'];
            $resultat = $this->classeService->supprimerClasse($idClasse, $prefetId);
            
            if ($resultat) {
                $_SESSION['success'] = "Classe supprimée avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression de la classe";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur : " . $e->getMessage();
        }
        
        header("Location: /prefet-etudes/classes");
        exit;
    }

    /**
     * Voir les détails d'une classe
     */
    public function voirClasse()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès réservé au préfet des études');
        }
        
        $idClasse = $_GET['id'] ?? null;
        if (!$idClasse) {
            header('HTTP/1.0 400 Bad Request');
            exit('ID de classe requis');
        }
        
        $classe = $this->classeService->getClasseComplete($idClasse);
        if (!$classe) {
            header('HTTP/1.0 404 Not Found');
            exit('Classe non trouvée');
        }
        
        $eleves = $this->classeService->getElevesClasse($idClasse);
        $enseignants = $this->classeService->getEnseignantsClasse($idClasse);
        $emploiDuTemps = $this->classeService->getEmploiDuTempsClasse($idClasse);
        $statistiques = $this->classeService->getStatistiquesClasse($idClasse);
        
        require __DIR__ . "/../../views/prefet_etudes/voir_classe.php";
    }

    /**
     * Importer des classes en masse
     */
    public function importerClasses()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès réservé au préfet des études');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichier_import'])) {
            $prefetId = $_SESSION['user_id'];
            
            try {
                $resultat = $this->classeService->importerClasses($_FILES['fichier_import'], $prefetId);
                
                if ($resultat['success']) {
                    $_SESSION['success'] = "Importation réussie : {$resultat['nb_ajoutees']} classes ajoutées, {$resultat['nb_modifiees']} modifiées";
                } else {
                    $_SESSION['error'] = "Erreur lors de l'importation : " . $resultat['message'];
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur : " . $e->getMessage();
            }
            
            header("Location: /prefet-etudes/importer-classes");
            exit;
        }
        
        require __DIR__ . "/../../views/prefet_etudes/importer_classes.php";
    }

    /**
     * Exporter la liste des classes
     */
    public function exporterClasses()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès réservé au préfet des études');
        }
        
        $format = $_GET['format'] ?? 'csv';
        $filtres = [
            'niveau' => $_GET['niveau'] ?? null,
            'cycle' => $_GET['cycle'] ?? null,
            'id_option' => $_GET['id_option'] ?? null,
            'id_section' => $_GET['id_section'] ?? null,
            'id_ecole' => $_GET['id_ecole'] ?? null,
            'annee_scolaire' => $_GET['annee_scolaire'] ?? null
        ];
        
        try {
            $donnees = $this->classeService->exporterClasses($filtres, $format);
            
            header('Content-Type: ' . $donnees['content_type']);
            header('Content-Disposition: attachment; filename="' . $donnees['filename'] . '"');
            echo $donnees['content'];
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de l'exportation : " . $e->getMessage();
            header("Location: /prefet-etudes/classes");
            exit;
        }
    }

    /**
     * Statistiques des classes
     */
    public function statistiques()
    {
        if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
            header('HTTP/1.0 403 Forbidden');
            exit('Accès réservé au préfet des études');
        }
        
        $periode = $_GET['periode'] ?? 'annee';
        $idEcole = $_GET['id_ecole'] ?? null;
        
        $statistiques = $this->classeService->getStatistiquesDetaillees($periode, $idEcole);
        $graphiques = $this->classeService->getDonneesGraphiques($periode, $idEcole);
        $ecoles = $this->classeService->getEcoles();
        
        require __DIR__ . "/../../views/prefet_etudes/statistiques.php";
    }
}
?>
