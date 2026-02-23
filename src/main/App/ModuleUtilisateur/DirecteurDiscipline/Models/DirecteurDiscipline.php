<?php
namespace App\ModuleUtilisateur\DirecteurDiscipline\Models;
use App\ModuleUtilisateur\Models\Utilisateur;

class DirecteurDiscipline extends Utilisateur
{
    // === ATTRIBUTS SPÉCIFIQUES ===
    private $idDirecteur;
    private $bureau;
    private $telephonePro;
    private $plagesDisponibilite;  // JSON ou array
    private $dateDebut;
    private $dateFin;

    // === CONSTRUCTEUR ===
    public function __construct(
        // Paramètres du parent (Utilisateur)
        $idUtilisateur = null,
        $nom = null,
        $prenom = null,
        $email = null,
        $telephone = null,
        $motDePasse = null,
        $role = 'directeur_discipline',  // Forcé
        $statut = 'actif',
        $dateCreation = null,
        $derniereConnexion = null,
        $photoProfil = null,
        $tokenReset = null,
        $tokenExpiration = null,
        
        // Paramètres spécifiques
        $idDirecteur = null,
        $bureau = null,
        $telephonePro = null,
        $plagesDisponibilite = null,
        $dateDebut = null,
        $dateFin = null
    ) {
        // Appel du constructeur parent
        parent::__construct(
            $idUtilisateur,
            $nom,
            $prenom,
            $email,
            $telephone,
            $motDePasse,
            $role,
            $statut,
            $dateCreation,
            $derniereConnexion,
            $photoProfil,
            $tokenReset,
            $tokenExpiration
        );
        
        // Initialisation des attributs spécifiques
        $this->idDirecteur = $idDirecteur ?? $idUtilisateur;
        $this->bureau = $bureau;
        $this->telephonePro = $telephonePro;
        $this->plagesDisponibilite = $plagesDisponibilite;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    // === GETTERS SPÉCIFIQUES ===
    public function getIdDirecteur() { return $this->idDirecteur; }
    public function getBureau() { return $this->bureau; }
    public function getTelephonePro() { return $this->telephonePro; }
    public function getPlagesDisponibilite() { return $this->plagesDisponibilite; }
    public function getDateDebut() { return $this->dateDebut; }
    public function getDateFin() { return $this->dateFin; }

    // === SETTERS SPÉCIFIQUES ===
    public function setIdDirecteur($id) { $this->idDirecteur = $id; return $this; }
    public function setBureau($bureau) { $this->bureau = $bureau; return $this; }
    public function setTelephonePro($tel) { $this->telephonePro = $tel; return $this; }
    public function setPlagesDisponibilite($plages) { $this->plagesDisponibilite = $plages; return $this; }
    public function setDateDebut($date) { $this->dateDebut = $date; return $this; }
    public function setDateFin($date) { $this->dateFin = $date; return $this; }

    // === MÉTHODES POUR LES PLAGES DE DISPONIBILITÉ ===

    /**
     * Ajouter une plage de disponibilité
     */
    public function ajouterPlageDisponibilite($jour, $heureDebut, $heureFin)
    {
        $plages = $this->getPlagesDisponibiliteArray();
        
        if (!isset($plages[$jour])) {
            $plages[$jour] = [];
        }
        
        $plages[$jour][] = $heureDebut . '-' . $heureFin;
        $this->plagesDisponibilite = json_encode($plages);
        
        return $this;
    }

    /**
     * Obtenir les plages de disponibilité sous forme de tableau
     */
    public function getPlagesDisponibiliteArray()
    {
        if (is_string($this->plagesDisponibilite)) {
            return json_decode($this->plagesDisponibilite, true) ?? [];
        }
        return $this->plagesDisponibilite ?? [];
    }

    /**
     * Vérifier si disponible à une date/heure donnée
     */
    public function estDisponible($date, $heure)
    {
        if ($this->dateFin && strtotime($date) > strtotime($this->dateFin)) {
            return false;
        }
        
        $jourSemaine = date('l', strtotime($date));
        $jours = [
            'Monday' => 'lundi',
            'Tuesday' => 'mardi',
            'Wednesday' => 'mercredi',
            'Thursday' => 'jeudi',
            'Friday' => 'vendredi',
            'Saturday' => 'samedi',
            'Sunday' => 'dimanche'
        ];
        
        $jourFr = $jours[$jourSemaine] ?? null;
        $plages = $this->getPlagesDisponibiliteArray();
        
        if (!isset($plages[$jourFr])) {
            return false;
        }
        
        foreach ($plages[$jourFr] as $plage) {
            list($debut, $fin) = explode('-', $plage);
            if ($heure >= $debut && $heure <= $fin) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Obtenir le nombre d'années d'ancienneté
     */
    public function getAnciennete()
    {
        if (!$this->dateDebut) return 0;
        $debut = new \DateTime($this->dateDebut);
        $today = new \DateTime();
        return $today->diff($debut)->y;
    }

    /**
     * Vérifier si toujours en fonction
     */
    public function estEnFonction()
    {
        if (!$this->dateFin) return true;
        return strtotime($this->dateFin) > time();
    }

    /**
     * Obtenir le bureau complet (étage + numéro)
     */
    public function getBureauComplet()
    {
        return $this->bureau ?? 'Non assigné';
    }

    /**
     * Obtenir le téléphone professionnel formaté
     */
    public function getTelephoneProFormate()
    {
        if (!$this->telephonePro) return 'Non renseigné';
        
        // Format: XX XX XX XX XX
        return preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1 $2 $3 $4 $5', $this->telephonePro);
    }

    /**
     * Obtenir les statistiques disciplinaires
     */
    public function getStatistiquesDiscipline($disciplineDAO)
    {
        return [
            'total_rapports' => $disciplineDAO->countByPersonnel($this->idDirecteur),
            'en_attente' => $disciplineDAO->countByStatutAndPersonnel('en_attente', $this->idDirecteur),
            'traites' => $disciplineDAO->countByStatutAndPersonnel('traite', $this->idDirecteur),
            'sanctionnes' => $disciplineDAO->countByStatutAndPersonnel('sanctionne', $this->idDirecteur)
        ];
    }

    // === HYDRATE ===
    public function hydrate(array $data)
    {
        // Hydrate d'abord le parent
        parent::hydrate($data);
        
        // Mapping des attributs spécifiques
        $mapping = [
            'id_directeur' => 'idDirecteur',
            'bureau' => 'bureau',
            'telephone_pro' => 'telephonePro',
            'plages_disponibilite' => 'plagesDisponibilite',
            'date_debut' => 'dateDebut',
            'date_fin' => 'dateFin'
        ];
        
        foreach ($mapping as $dbKey => $property) {
            if (isset($data[$dbKey])) {
                $this->$property = $data[$dbKey];
            }
        }
        
        return $this;
    }

    // === TOARRAY ===
    public function toArray($mode = 'db')
    {
        $parentArray = parent::toArray();
        
        $specificArray = [
            'id_directeur' => $this->idDirecteur,
            'bureau' => $this->bureau,
            'telephone_pro' => $this->telephonePro,
            'plages_disponibilite' => $this->plagesDisponibilite,
            'date_debut' => $this->dateDebut,
            'date_fin' => $this->dateFin
        ];
        
        if ($mode === 'api') {
            $specificArray = array_merge($specificArray, [
                'bureau_complet' => $this->getBureauComplet(),
                'telephone_pro_formate' => $this->getTelephoneProFormate(),
                'plages' => $this->getPlagesDisponibiliteArray(),
                'anciennete' => $this->getAnciennete(),
                'en_fonction' => $this->estEnFonction()
            ]);
        }
        
        return array_merge($parentArray, $specificArray);
    }
}