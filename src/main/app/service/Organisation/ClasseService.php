<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__. "../../../dao/Organisation/ClasseDAO.php";

class ClasseService{
    private ClasseDAO $classe_dao;

    public function __construct()
    {
        $this->classe_dao = new ClasseDAO();
    }
    //netoyer les donnees
    private function cleanData($data){
        return htmlspecialchars(trim($data));
    }
    /**
     * create and update
     */
    public function createClasse(Classe $classe){
        $classe->setNomClasse($this->cleanData($classe->getNomClasse()));
        $classe->setNiveau($this->cleanData($classe->getNiveau()));
        $classe->setIdEtablissement($this->cleanData($classe->getIdEtablissement()));
        $classe->setDescription($this->cleanData($classe->getDescription()));
        $classe->setEffectifMaximal($this->cleanData($classe->getEffectifMaximal()));
        $classe->setSalle($this->cleanData($classe->getSalle()));
        $classe->setEffectifActuel($this->cleanData($classe->getEffectifActuel()));
        $classe->setAnneeScolaire($this->cleanData($classe->getAnneeScolaire()));

        //verifier les donnees
        if(empty($classe->getNomClasse()) || empty($classe->getNiveau()) || empty($classe->getIdEtablissement()) || empty($classe->getDescription()) || empty($classe->getEffectifMaximal()) || empty($classe->getSalle()) || empty($classe->getEffectifActuel()) || empty($classe->getAnneeScolaire())){
            throw new Exception("Tous les champs sont obligatoires");
        }

        if($classe->getIdClasse()){
            return $this->classe_dao->UpdateClasse($classe);
        }else{
            return $this->classe_dao->CreateClasse($classe);
        }
    }
    /**
     * modifier une classe
     */
    public function modifierClasse(Classe $classe){
        return $this->classe_dao->UpdateClasse($classe);
    }
    /**
     * afficher une classe par son ID
     */
    public function afficherClasse($id_classe){
        return $this->classe_dao->getOneClasse($id_classe);
    }
    /**
     * afficher toutes les classes
     */
    public function afficherToutesLesClasses(){
        return $this->classe_dao->getAllClasse();
    }
    /**
     * supprimer une classe
     */
    public function supprimerClasse($id_classe){
        return $this->classe_dao->DeleteOneClasse($id_classe);
    }

    /**
     * Ajouter une classe par le préfet des études
     */
    public function ajouterClasse(Classe $classe, $prefetId){
        // Nettoyer et valider les données
        $classe->setNomClasse($this->cleanData($classe->getNomClasse()));
        $classe->setNiveau($this->cleanData($classe->getNiveau()));
        $classe->setCycle($this->cleanData($classe->getCycle()));
        $classe->setIdEcole($this->cleanData($classe->getIdEcole()));
        $classe->setDescription($this->cleanData($classe->getDescription()));
        $classe->setCapacite($this->cleanData($classe->getCapacite()));

        // Validation spécifique pour le préfet
        if(empty($classe->getNomClasse()) || empty($classe->getNiveau()) || empty($classe->getCycle()) || empty($classe->getIdEcole())){
            throw new Exception("Les champs nom, niveau, cycle et école sont obligatoires");
        }

        // Journalisation de l'action
        $this->journaliserAction($prefetId, 'AJOUT_CLASSE', "Ajout de la classe: " . $classe->getNomClasse());

        return $this->classe_dao->CreateClasse($classe);
    }

    /**
     * Modifier une classe par le préfet des études
     */
    public function modifierClassePrefet(Classe $classe, $prefetId){
        // Nettoyer les données
        $classe->setNomClasse($this->cleanData($classe->getNomClasse()));
        $classe->setNiveau($this->cleanData($classe->getNiveau()));
        $classe->setCycle($this->cleanData($classe->getCycle()));
        $classe->setIdEcole($this->cleanData($classe->getIdEcole()));
        $classe->setDescription($this->cleanData($classe->getDescription()));
        $classe->setCapacite($this->cleanData($classe->getCapacite()));

        // Journalisation
        $this->journaliserAction($prefetId, 'MODIF_CLASSE', "Modification de la classe: " . $classe->getNomClasse());

        return $this->classe_dao->UpdateClasse($classe);
    }

    /**
     * Supprimer une classe par le préfet des études
     */
    public function supprimerClassePrefet($id_classe, $prefetId){
        $classe = $this->classe_dao->getOneClasse($id_classe);
        if ($classe) {
            $this->journaliserAction($prefetId, 'SUPPR_CLASSE', "Suppression de la classe: " . $classe->getNomClasse());
        }
        return $this->classe_dao->DeleteOneClasse($id_classe);
    }

    /**
     * Obtenir les statistiques des classes
     */
    public function getStatistiquesClasses(){
        return $this->classe_dao->getStatistiques();
    }

    /**
     * Obtenir les classes récentes
     */
    public function getClassesRecentes(){
        return $this->classe_dao->getClassesRecentes();
    }

    /**
     * Obtenir les propositions en attente
     */
    public function getPropositionsEnAttente(){
        return $this->classe_dao->getPropositionsEnAttente();
    }

    /**
     * Obtenir les options d'étude
     */
    public function getOptionsEtude(){
        return $this->classe_dao->getAllOptions();
    }

    /**
     * Obtenir les sections
     */
    public function getSections(){
        return $this->classe_dao->getAllSections();
    }

    /**
     * Obtenir les écoles
     */
    public function getEcoles(){
        return $this->classe_dao->getAllEcoles();
    }

    /**
     * Obtenir les années scolaires
     */
    public function getAnneesScolaires(){
        return $this->classe_dao->getAllAnneesScolaires();
    }

    /**
     * Obtenir les classes avec filtres
     */
    public function getClassesFiltrees($filtres){
        return $this->classe_dao->getClassesFiltrees($filtres);
    }

    /**
     * Obtenir une classe par ID
     */
    public function getClasseParId($idClasse){
        return $this->classe_dao->getOneClasse($idClasse);
    }

    /**
     * Obtenir une classe complète avec toutes ses informations
     */
    public function getClasseComplete($idClasse){
        return $this->classe_dao->getClasseComplete($idClasse);
    }

    /**
     * Obtenir les élèves d'une classe
     */
    public function getElevesClasse($idClasse){
        return $this->classe_dao->getElevesClasse($idClasse);
    }

    /**
     * Obtenir les enseignants d'une classe
     */
    public function getEnseignantsClasse($idClasse){
        return $this->classe_dao->getEnseignantsClasse($idClasse);
    }

    /**
     * Obtenir l'emploi du temps d'une classe
     */
    public function getEmploiDuTempsClasse($idClasse){
        return $this->classe_dao->getEmploiDuTempsClasse($idClasse);
    }

    /**
     * Obtenir les statistiques d'une classe
     */
    public function getStatistiquesClasse($idClasse){
        return $this->classe_dao->getStatistiquesClasse($idClasse);
    }

    /**
     * Importer des classes en masse
     */
    public function importerClasses($fichier, $prefetId){
        $resultat = $this->classe_dao->importerClasses($fichier);
        
        if ($resultat['success']) {
            $this->journaliserAction($prefetId, 'IMPORT_CLASSES', 
                "Importation de {$resultat['nb_ajoutees']} classes");
        }
        
        return $resultat;
    }

    /**
     * Exporter les classes
     */
    public function exporterClasses($filtres, $format){
        return $this->classe_dao->exporterClasses($filtres, $format);
    }

    /**
     * Obtenir les statistiques détaillées
     */
    public function getStatistiquesDetaillees($periode, $idEcole){
        return $this->classe_dao->getStatistiquesDetaillees($periode, $idEcole);
    }

    /**
     * Obtenir les données pour graphiques
     */
    public function getDonneesGraphiques($periode, $idEcole){
        return $this->classe_dao->getDonneesGraphiques($periode, $idEcole);
    }

    /**
     * Journaliser une action
     */
    private function journaliserAction($utilisateurId, $action, $description){
        // Implémentation de la journalisation
        // À connecter avec la table journal_activite
        try {
            $this->classe_dao->journaliserAction($utilisateurId, $action, $description);
        } catch (Exception $e) {
            // En cas d'erreur de journalisation, on continue sans bloquer
            error_log("Erreur de journalisation: " . $e->getMessage());
        }
    }

}

?>