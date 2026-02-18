<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Gamification;

class Badge
{
    private  $id_badge;
    private  $nom_badge;
    private  $date_obtention;

    public function __construct(
         $id_badge = null,
         $nom_badge = null,
         $date_obtention = null,
    ) {
        $this->id_badge = $id_badge;
        $this->nom_badge = $nom_badge;
        $this->date_obtention = $date_obtention;
    }

    public function getIdBadge() { return $this->id_badge; }
    public function setIdBadge( $id) { $this->id_badge = $id; }

    public function getNomBadge() { return $this->nom_badge; }
    public function setNomBadge( $nom_badge) { $this->nom_badge = $nom_badge; }

    public function getDateObtention(){ return $this->date_obtention; }
    public function setDateObtention($date_obtention): void { $this->date_obtention = $date_obtention; }
}
