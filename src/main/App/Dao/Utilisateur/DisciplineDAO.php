<?php
namespace App\Dao\Discipline;

use App\Models\Discipline\Discipline;
use App\config\Model;
use PDO;
use PDOException;

class DisciplineDAO extends Model
{
    protected $table = "discipline";
    protected $primaryKey = "id_discipline";

    public function __construct()
    {
        parent::__construct();
    }

    // ============================================================
    // MÉTHODES CRUD DE BASE
    // ============================================================

    /**
     * Créer un objet Discipline à partir d'une ligne de résultat
     */
    public function createEntity($row)
    {
        $discipline = new Discipline();
        return $discipline->hydrate($row);
    }

    /**
     * Sauvegarder un rapport disciplinaire (création ou mise à jour)
     */
    public function save(Discipline $discipline)
    {
        $data = $discipline->toArray();
        
        // Retirer l'ID pour la création
        if (empty($data['id_discipline'])) {
            unset($data['id_discipline']);
        }
        
        // Si c'est une mise à jour
        if ($discipline->getIdDiscipline()) {
            return $this->update($discipline->getIdDiscipline(), $data);
        }
        
        // Si c'est une création
        $id = $this->create($data);
        if ($id) {
            $discipline->setIdDiscipline($id);
            return true;
        }
        
        return false;
    }

    /**
     * Trouver un rapport par son ID
     */
    public function find($id)
    {
        $data = parent::find($id);
        return $data ? $this->createEntity($data) : null;
    }

    /**
     * Trouver tous les rapports
     */
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY date_infraction DESC";
        $stmt = $this->db->query($sql);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Supprimer un rapport
     */
    public function delete($id)
    {
        return parent::delete($id);
    }

    // ============================================================
    // MÉTHODES DE RECHERCHE SPÉCIFIQUES
    // ============================================================

    /**
     * Trouver les rapports d'un élève
     */
    public function findByEleve($eleveId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE id_eleve = :eleve_id 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['eleve_id' => $eleveId]);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports signalés par un personnel
     */
    public function findByPersonnel($personnelId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE id_personnel_rapport = :personnel_id 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['personnel_id' => $personnelId]);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports par statut
     */
    public function findByStatut($statut)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE statut = :statut 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['statut' => $statut]);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports par type d'infraction
     */
    public function findByTypeInfraction($typeInfraction)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE type_infraction = :type 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['type' => $typeInfraction]);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports où un parent est informé
     */
    public function findByParentInforme($parentId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE id_parent_informe = :parent_id 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['parent_id' => $parentId]);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports avec sanction
     */
    public function findWithSanction()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE sanction IS NOT NULL AND sanction != '' 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->query($sql);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports sans sanction
     */
    public function findWithoutSanction()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (sanction IS NULL OR sanction = '') 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->query($sql);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    // ============================================================
    // MÉTHODES DE RECHERCHE PAR DATE
    // ============================================================

    /**
     * Trouver les rapports entre deux dates
     */
    public function findByDateRange($dateDebut, $dateFin)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE date_infraction BETWEEN :debut AND :fin 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'debut' => $dateDebut,
            'fin' => $dateFin
        ]);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports d'aujourd'hui
     */
    public function findToday()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE DATE(date_infraction) = CURDATE() 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->query($sql);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports de cette semaine
     */
    public function findThisWeek()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE YEARWEEK(date_infraction) = YEARWEEK(CURDATE()) 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->query($sql);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports de ce mois
     */
    public function findThisMonth()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE MONTH(date_infraction) = MONTH(CURDATE()) 
                AND YEAR(date_infraction) = YEAR(CURDATE())
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->query($sql);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Trouver les rapports récents (moins de X jours)
     */
    public function findRecent($jours = 7)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE date_infraction >= DATE_SUB(NOW(), INTERVAL :jours DAY) 
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['jours' => $jours]);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    // ============================================================
    // MÉTHODES DE MISE À JOUR SPÉCIFIQUES
    // ============================================================

    /**
     * Mettre à jour le statut d'un rapport
     */
    public function updateStatut($id, $statut)
    {
        $sql = "UPDATE {$this->table} SET statut = :statut WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'statut' => $statut,
            'id' => $id
        ]);
    }

    /**
     * Ajouter une sanction à un rapport
     */
    public function addSanction($id, $sanction, $dureeSanction = null)
    {
        $sql = "UPDATE {$this->table} 
                SET sanction = :sanction, 
                    duree_sanction = :duree, 
                    statut = 'sanctionne' 
                WHERE {$this->primaryKey} = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'sanction' => $sanction,
            'duree' => $dureeSanction,
            'id' => $id
        ]);
    }

    /**
     * Marquer un parent comme informé
     */
    public function marquerParentInforme($id, $idParent)
    {
        $sql = "UPDATE {$this->table} 
                SET id_parent_informe = :parent_id, 
                    statut = 'parent_informe' 
                WHERE {$this->primaryKey} = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'parent_id' => $idParent,
            'id' => $id
        ]);
    }

    /**
     * Classer un rapport sans suite
     */
    public function classerSansSuite($id)
    {
        return $this->updateStatut($id, 'classe');
    }

    // ============================================================
    // MÉTHODES DE RECHERCHE AVANCÉE
    // ============================================================

    /**
     * Recherche multicritères
     */
    public function search($criteria = [])
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        if (!empty($criteria['id_eleve'])) {
            $sql .= " AND id_eleve = :id_eleve";
            $params['id_eleve'] = $criteria['id_eleve'];
        }
        
        if (!empty($criteria['type_infraction'])) {
            $sql .= " AND type_infraction = :type_infraction";
            $params['type_infraction'] = $criteria['type_infraction'];
        }
        
        if (!empty($criteria['statut'])) {
            $sql .= " AND statut = :statut";
            $params['statut'] = $criteria['statut'];
        }
        
        if (!empty($criteria['date_debut']) && !empty($criteria['date_fin'])) {
            $sql .= " AND date_infraction BETWEEN :date_debut AND :date_fin";
            $params['date_debut'] = $criteria['date_debut'];
            $params['date_fin'] = $criteria['date_fin'];
        }
        
        if (!empty($criteria['lieu'])) {
            $sql .= " AND lieu LIKE :lieu";
            $params['lieu'] = '%' . $criteria['lieu'] . '%';
        }
        
        if (!empty($criteria['a_sanction'])) {
            if ($criteria['a_sanction'] === true) {
                $sql .= " AND sanction IS NOT NULL AND sanction != ''";
            } else {
                $sql .= " AND (sanction IS NULL OR sanction = '')";
            }
        }
        
        if (!empty($criteria['parent_informe'])) {
            if ($criteria['parent_informe'] === true) {
                $sql .= " AND id_parent_informe IS NOT NULL";
            } else {
                $sql .= " AND id_parent_informe IS NULL";
            }
        }
        
        $sql .= " ORDER BY date_infraction DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    /**
     * Recherche textuelle dans les descriptions
     */
    public function searchText($motCle)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE description LIKE :mot_cle 
                   OR lieu LIKE :mot_cle 
                   OR temoins LIKE :mot_cle
                   OR type_infraction LIKE :mot_cle
                ORDER BY date_infraction DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['mot_cle' => '%' . $motCle . '%']);
        
        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = $this->createEntity($row);
        }
        
        return $resultats;
    }

    // ============================================================
    // MÉTHODES DE COMPTAGE ET STATISTIQUES
    // ============================================================

    /**
     * Compter le nombre total de rapports
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        return $this->db->query($sql)->fetchColumn();
    }

    /**
     * Compter les rapports par statut
     */
    public function countByStatut()
    {
        $sql = "SELECT statut, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY statut";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
     * Compter les rapports par type d'infraction
     */
    public function countByTypeInfraction()
    {
        $sql = "SELECT type_infraction, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY type_infraction 
                ORDER BY total DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Compter les rapports par élève
     */
    public function countByEleve($eleveId = null)
    {
        if ($eleveId) {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE id_eleve = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$eleveId]);
            return $stmt->fetchColumn();
        }
        
        $sql = "SELECT id_eleve, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY id_eleve 
                ORDER BY total DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtenir les statistiques complètes
     */
    public function getStatistiques()
    {
        $stats = [];
        
        // Total général
        $stats['total'] = $this->count();
        
        // Par statut
        $stats['par_statut'] = $this->countByStatut();
        
        // Par type d'infraction
        $stats['par_type'] = $this->countByTypeInfraction();
        
        // Évolution mensuelle (12 derniers mois)
        $sql = "SELECT DATE_FORMAT(date_infraction, '%Y-%m') as mois, 
                       COUNT(*) as total
                FROM {$this->table}
                WHERE date_infraction >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY mois
                ORDER BY mois";
        
        $stats['evolution'] = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
        // Top 10 des élèves les plus signalés
        $sql = "SELECT e.nom, e.prenom, e.matricule, COUNT(d.id_discipline) as nb_rapports
                FROM {$this->table} d
                JOIN eleve e ON d.id_eleve = e.id_eleve
                GROUP BY d.id_eleve
                ORDER BY nb_rapports DESC
                LIMIT 10";
        
        $stats['top_eleves'] = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
        // Rapports avec/sans sanction
        $sql = "SELECT 
                    SUM(CASE WHEN sanction IS NOT NULL AND sanction != '' THEN 1 ELSE 0 END) as avec_sanction,
                    SUM(CASE WHEN sanction IS NULL OR sanction = '' THEN 1 ELSE 0 END) as sans_sanction
                FROM {$this->table}";
        
        $stats['sanctions'] = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        
        // Délai moyen de traitement
        $sql = "SELECT AVG(DATEDIFF(date_rapport, date_infraction)) as delai_moyen
                FROM {$this->table}
                WHERE date_rapport IS NOT NULL";
        
        $stats['delai_moyen'] = round($this->db->query($sql)->fetchColumn() ?? 0);
        
        return $stats;
    }

    // ============================================================
    // MÉTHODES AVEC JOINTURES (pour avoir les noms des élèves/personnels)
    // ============================================================

    /**
     * Trouver un rapport avec les détails (élève, personnel)
     */
    public function findWithDetails($id)
    {
        $sql = "SELECT d.*, 
                       e.nom as eleve_nom, 
                       e.prenom as eleve_prenom, 
                       e.matricule as eleve_matricule,
                       u.nom as personnel_nom, 
                       u.prenom as personnel_prenom,
                       p.nom as parent_nom, 
                       p.prenom as parent_prenom
                FROM {$this->table} d
                LEFT JOIN eleve e ON d.id_eleve = e.id_eleve
                LEFT JOIN utilisateur u ON d.id_personnel_rapport = u.id_utilisateur
                LEFT JOIN tuteur p ON d.id_parent_informe = p.id_tuteur
                WHERE d.{$this->primaryKey} = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Trouver tous les rapports avec détails
     */
    public function findAllWithDetails()
    {
        $sql = "SELECT d.*, 
                       e.nom as eleve_nom, 
                       e.prenom as eleve_prenom, 
                       e.matricule as eleve_matricule,
                       u.nom as personnel_nom, 
                       u.prenom as personnel_prenom
                FROM {$this->table} d
                LEFT JOIN eleve e ON d.id_eleve = e.id_eleve
                LEFT JOIN utilisateur u ON d.id_personnel_rapport = u.id_utilisateur
                ORDER BY d.date_infraction DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // MÉTHODES BULK (opérations en lot)
    // ============================================================

    /**
     * Supprimer tous les rapports d'un élève
     */
    public function deleteByEleve($eleveId)
    {
        $sql = "DELETE FROM {$this->table} WHERE id_eleve = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$eleveId]);
    }

    /**
     * Mettre à jour le statut de plusieurs rapports
     */
    public function updateStatutBulk($ids, $statut)
    {
        if (empty($ids)) return false;
        
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "UPDATE {$this->table} SET statut = ? WHERE {$this->primaryKey} IN ($placeholders)";
        
        $params = array_merge([$statut], $ids);
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // ============================================================
    // MÉTHODES D'EXPORT
    // ============================================================

    /**
     * Exporter les rapports pour un élève (format CSV)
     */
    public function exportForEleve($eleveId)
    {
        $rapports = $this->findByEleve($eleveId);
        
        $csv = "ID;Date;Type;Description;Lieu;Sanction;Statut\n";
        
        foreach ($rapports as $rapport) {
            $csv .= implode(';', [
                $rapport->getIdDiscipline(),
                $rapport->getDateIncidentFormatee(),
                $rapport->getTypeInfraction(),
                $rapport->getDescriptionResumee(),
                $rapport->getLieuIncidentFormate(),
                $rapport->getSanctionFormatee(),
                $rapport->getStatutLibelle()
            ]) . "\n";
        }
        
        return $csv;
    }

    /**
     * Exporter les statistiques (format CSV)
     */
    public function exportStatistiques()
    {
        $stats = $this->getStatistiques();
        
        $csv = "=== STATISTIQUES DISCIPLINAIRES ===\n\n";
        $csv .= "Total des rapports: " . $stats['total'] . "\n\n";
        
        $csv .= "PAR STATUT:\n";
        foreach ($stats['par_statut'] as $statut => $total) {
            $csv .= "- $statut: $total\n";
        }
        
        $csv .= "\nPAR TYPE D'INFRACTION:\n";
        foreach ($stats['par_type'] as $type) {
            $csv .= "- " . $type['type_infraction'] . ": " . $type['total'] . "\n";
        }
        
        return $csv;
    }
}
?>