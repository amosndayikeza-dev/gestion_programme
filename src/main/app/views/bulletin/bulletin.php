<?php
/**
 * Classe pour générer le bulletin scolaire RDC
 * Format officiel du Ministère de l'Enseignement Primaire, Secondaire et Professionnel
 */

class BulletinScolaireRDC {
    private $studentData;
    private $schoolData;
    private $academicData;
    private $gradesData;
    
    public function __construct(array $studentData, array $schoolData, array $academicData, array $gradesData) {
        $this->studentData = $studentData;
        $this->schoolData = $schoolData;
        $this->academicData = $academicData;
        $this->gradesData = $gradesData;
    }
    
    public function render(): string {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Bulletin Scolaire - RDC</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman:wght@400;700&display=swap');
                
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: 'Times New Roman', Times, serif;
                }
                
                body {
                    background-color: #ffffff;
                    color: #000000;
                    font-size: 10pt;
                    line-height: 1.2;
                    padding: 20px;
                    max-width: 800px;
                    margin: 0 auto;
                }
                
                .bulletin-container {
                    border: 2px solid #000000;
                    padding: 15px;
                    position: relative;
                }
                
                .header {
                    text-align: center;
                    border-bottom: 2px solid #000000;
                    padding-bottom: 8px;
                    margin-bottom: 15px;
                }
                
                .ministry {
                    font-size: 11pt;
                    font-weight: bold;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    margin-bottom: 3px;
                }
                
                .id-number {
                    text-align: center;
                    font-size: 10pt;
                    margin: 8px 0;
                    letter-spacing: 2px;
                }
                
                .province {
                    text-align: center;
                    font-weight: bold;
                    text-transform: uppercase;
                    font-size: 11pt;
                    margin: 10px 0;
                    border: 1px solid #000;
                    padding: 3px;
                    background-color: #f0f0f0;
                }
                
                .school-info {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 15px;
                    margin: 15px 0;
                    font-size: 10pt;
                }
                
                .student-info {
                    display: grid;
                    grid-template-columns: 1fr 1fr 1fr;
                    gap: 10px;
                    margin: 15px 0;
                    font-size: 10pt;
                    border-top: 1px solid #000;
                    border-bottom: 1px solid #000;
                    padding: 8px 0;
                }
                
                .info-item {
                    margin-bottom: 3px;
                }
                
                .info-label {
                    font-weight: bold;
                }
                
                .underline {
                    display: inline-block;
                    border-bottom: 1px solid #000;
                    min-width: 150px;
                    text-align: center;
                    margin-left: 5px;
                }
                
                .bulletin-title {
                    text-align: center;
                    font-weight: bold;
                    font-size: 11pt;
                    text-transform: uppercase;
                    margin: 15px 0;
                    border: 1px solid #000;
                    padding: 5px;
                    background-color: #f0f0f0;
                }
                
                .grades-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    font-size: 9pt;
                }
                
                .grades-table th,
                .grades-table td {
                    border: 1px solid #000;
                    padding: 3px;
                    text-align: center;
                    vertical-align: middle;
                }
                
                .grades-table th {
                    background-color: #f0f0f0;
                    font-weight: bold;
                    font-size: 8.5pt;
                }
                
                .column-group {
                    background-color: #e0e0e0;
                }
                
                .subject-column {
                    text-align: left !important;
                    font-weight: bold;
                    width: 20%;
                }
                
                .maxima-row {
                    font-weight: bold;
                    background-color: #f8f8f8;
                }
                
                .totals-section {
                    margin: 20px 0;
                    border: 1px solid #000;
                    padding: 10px;
                }
                
                .totals-grid {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 15px;
                    margin: 10px 0;
                }
                
                .total-item {
                    text-align: center;
                }
                
                .total-label {
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                
                .total-value {
                    border: 1px solid #000;
                    padding: 5px;
                    min-height: 30px;
                }
                
                .decisions-section {
                    margin: 25px 0;
                    border-top: 1px solid #000;
                    padding-top: 15px;
                }
                
                .decision-item {
                    margin-bottom: 8px;
                    position: relative;
                    padding-left: 25px;
                }
                
                .decision-checkbox {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 15px;
                    height: 15px;
                    border: 1px solid #000;
                    display: inline-block;
                    margin-right: 5px;
                }
                
                .footer {
                    margin-top: 30px;
                    text-align: center;
                }
                
                .date-place {
                    margin: 20px 0;
                    text-align: left;
                }
                
                .signatures {
                    display: grid;
                    grid-template-columns: 1fr 1fr 1fr;
                    gap: 20px;
                    margin-top: 30px;
                    text-align: center;
                }
                
                .signature-box {
                    border-top: 1px solid #000;
                    padding-top: 40px;
                    min-height: 100px;
                }
                
                .signature-label {
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                
                .note-important {
                    margin-top: 20px;
                    font-size: 8.5pt;
                    font-style: italic;
                    text-align: center;
                    border: 1px solid #000;
                    padding: 8px;
                    background-color: #fff0f0;
                }
                
                .page-break {
                    page-break-after: always;
                }
                
                @media print {
                    body {
                        padding: 0;
                        margin: 0;
                    }
                    
                    .bulletin-container {
                        border: none;
                        padding: 0;
                    }
                    
                    .no-print {
                        display: none;
                    }
                }
                
                .text-center {
                    text-align: center;
                }
                
                .text-left {
                    text-align: left;
                }
                
                .text-right {
                    text-align: right;
                }
                
                .bold {
                    font-weight: bold;
                }
                
                .uppercase {
                    text-transform: uppercase;
                }
            </style>
        </head>
        <body>
            <div class="bulletin-container">
                <!-- En-tête -->
                <div class="header">
                    <div class="ministry">REPUBLIQUE DEMOCRATIQUE DU CONGO</div>
                    <div class="ministry">MINISTERE DE L'ENSEIGNEMENT PRIMAIRE, SECONDAIRE ET PROFESSIONNEL</div>
                    
                    <div class="id-number">
                        <span class="bold">N° ID.</span> 9 - 1 0 0 1 7 1 0 7 0 0 0 2 5 5
                    </div>
                </div>
                
                <!-- Province -->
                <div class="province">
                    PROVINCE (DU NORD-KIVU)
                </div>
                
                <!-- Informations école -->
                <div class="school-info">
                    <div class="info-item">
                        <span class="info-label">VILLE :</span>
                        <span class="underline"><?php echo htmlspecialchars($this->schoolData['ville'] ?? 'RENI'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">COMMUNE :</span>
                        <span class="underline"><?php echo htmlspecialchars($this->schoolData['commune'] ?? 'BURUGULU'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">ECOLE :</span>
                        <span class="underline"><?php echo htmlspecialchars($this->schoolData['ecole'] ?? 'INSTITUT BUNGUULU'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">CODE :</span>
                        <span class="underline"><?php echo htmlspecialchars($this->schoolData['code'] ?? '62024 / 101 / 01 / 1'); ?></span>
                    </div>
                </div>
                
                <!-- Informations élève -->
                <div class="student-info">
                    <div class="info-item">
                        <span class="info-label">ELEVE :</span>
                        <span class="underline"><?php echo htmlspecialchars($this->studentData['nom'] ?? ''); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">FRE(1) A :</span>
                        <span class="underline"><?php echo htmlspecialchars($this->studentData['fre'] ?? ''); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">CLASSE :</span>
                        <span class="underline"><?php echo htmlspecialchars($this->studentData['classe'] ?? ''); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">N° PVRM. :</span>
                        <span class="decision-checkbox"></span>
                    </div>
                </div>
                
                <!-- Titre du bulletin -->
                <div class="bulletin-title">
                    BULLETIN DE LA 1ʳᵉ, 2ᵉʳᵗ (1) ANNEE SECONDAIRE<br>
                    ANNEE SCOLAIRE <?php echo htmlspecialchars($this->academicData['annee_scolaire'] ?? '20__ - 20__'); ?>
                </div>
                
                <!-- Tableau des notes -->
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th rowspan="2">BRANCHES</th>
                            <th colspan="4">PREMIER SEMESTRE</th>
                            <th colspan="4">SECOND SEMESTRE</th>
                            <th rowspan="2">EXAMEN DE REPÊCHAGE</th>
                            <th rowspan="2">%</th>
                            <th rowspan="2">SIGN. PROF.</th>
                        </tr>
                        <tr>
                            <th colspan="3">TR. JOURNAL</th>
                            <th rowspan="2" class="column-group">TOT.</th>
                            <th colspan="3">TR. JOURNAL</th>
                            <th rowspan="2" class="column-group">TOT.</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>1ʳᵉ P</th>
                            <th>2ᵉ P</th>
                            <th>EXAM</th>
                            <th>3ᵉ P</th>
                            <th>4ᵉ P</th>
                            <th>EXAM</th>
                            <th>T.G.</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Maxima -->
                        <tr class="maxima-row">
                            <td class="subject-column">MAXIMA</td>
                            <td>20</td>
                            <td>40</td>
                            <td>80</td>
                            <td>160</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <!-- Matières générales -->
                        <?php $this->renderSubjectRow('RELIGION', $this->gradesData['religion'] ?? []); ?>
                        <?php $this->renderSubjectRow('ÉDUC. CIV & MORALE', $this->gradesData['education_civique'] ?? []); ?>
                        <?php $this->renderSubjectRow('EDUCATION À LA VIE', $this->gradesData['education_vie'] ?? []); ?>
                        
                        <!-- Maxima -->
                        <tr class="maxima-row">
                            <td class="subject-column">MAXIMA</td>
                            <td>30</td>
                            <td>60</td>
                            <td>120</td>
                            <td>240</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <!-- Matières principales -->
                        <?php $this->renderSubjectRow('FRANÇAIS', $this->gradesData['francais'] ?? []); ?>
                        <?php $this->renderSubjectRow('MEXICAN', $this->gradesData['mexican'] ?? []); ?>
                        <?php $this->renderSubjectRow('GEOGRAPHIE', $this->gradesData['geographie'] ?? []); ?>
                        <?php $this->renderSubjectRow('HISTOIRE', $this->gradesData['histoire'] ?? []); ?>
                        
                        <!-- Maxima -->
                        <tr class="maxima-row">
                            <td class="subject-column">MAXIMA</td>
                            <td>60</td>
                            <td>120</td>
                            <td>240</td>
                            <td>480</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <!-- Matières scientifiques -->
                        <?php $this->renderSubjectRow('FRANÇAIS', $this->gradesData['francais2'] ?? []); ?>
                        <?php $this->renderSubjectRow('MATHÉMATIQUE', $this->gradesData['mathematique'] ?? []); ?>
                    </tbody>
                </table>
                
                <!-- Totaux et résultats -->
                <div class="totals-section">
                    <div class="totals-grid">
                        <div class="total-item">
                            <div class="total-label">TOTAUX</div>
                            <div class="total-value"></div>
                        </div>
                        <div class="total-item">
                            <div class="total-label">PORTEFEUILLE</div>
                            <div class="total-value"></div>
                        </div>
                        <div class="total-item">
                            <div class="total-label">PLACEMENT DES ELEVÉS</div>
                            <div class="total-value"></div>
                        </div>
                        <div class="total-item">
                            <div class="total-label">APPLICATION</div>
                            <div class="total-value"></div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div>
                            <div class="total-label">CONDUITE</div>
                            <div class="total-value" style="min-height: 40px;"></div>
                        </div>
                        <div>
                            <div class="total-label">SIGNATURE DU RESPONSABLE</div>
                            <div class="total-value" style="min-height: 40px;"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Décisions -->
                <div class="decisions-section">
                    <div class="decision-item">
                        <span class="decision-checkbox"></span>
                        L'élève ne pourra passer dans la classe supérieure s'il n'a subi avec succès un examen de répéché en ______ (1)
                    </div>
                    <div class="decision-item">
                        <span class="decision-checkbox"></span>
                        L'élève passe dans la classe supérieure (1)
                    </div>
                    <div class="decision-item">
                        <span class="decision-checkbox"></span>
                        L'élève double sa classe (3)
                    </div>
                    <div class="decision-item">
                        <span class="decision-checkbox"></span>
                        L'élève a échoué et est à retourner vers ______ (1)
                    </div>
                </div>
                
                <!-- Date et lieu -->
                <div class="date-place">
                    <div class="bold">Fait à Mwene-Ditu, le ______ /______ /19______</div>
                    <div style="margin-top: 30px; text-align: center;" class="bold">Le Chef d'Établissement</div>
                </div>
                
                <!-- Signatures -->
                <div class="signatures">
                    <div class="signature-box">
                        <div class="signature-label">Signature de l'élève</div>
                    </div>
                    <div class="signature-box">
                        <div class="signature-label">Sceau de l'école</div>
                    </div>
                    <div class="signature-box">
                        <div class="signature-label">Nom et Signature</div>
                    </div>
                </div>
                
                <!-- Notes -->
                <div class="note-important">
                    (1) Effacer la mention inutile.<br>
                    Note importante : Le bulletin est sans valeur s'il est retiré ou surchargé.
                </div>
            </div>
            
            <!-- Bouton d'impression (visible seulement à l'écran) -->
            <div class="no-print" style="margin-top: 30px; text-align: center;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #0066cc; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
                    <i class="fas fa-print"></i> Imprimer le Bulletin
                </button>
            </div>
            
            <script>
                // Script pour remplir dynamiquement les notes si données disponibles
                document.addEventListener('DOMContentLoaded', function() {
                    // Remplir les cases avec les données disponibles
                    const studentName = "<?php echo $this->studentData['nom'] ?? ''; ?>";
                    if (studentName) {
                        const nameField = document.querySelector('.student-info .underline');
                        if (nameField) nameField.textContent = studentName;
                    }
                    
                    // Calculer les totaux si données disponibles
                    <?php if (!empty($this->gradesData)): ?>
                        calculateTotals();
                    <?php endif; ?>
                });
                
                function calculateTotals() {
                    // Cette fonction pourrait calculer automatiquement les totaux
                    // en fonction des notes entrées
                    console.log('Calcul des totaux...');
                }
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
    
    private function renderSubjectRow(string $subject, array $grades): void {
        $firstSemester = $grades['first_semester'] ?? ['p1' => '', 'p2' => '', 'exam' => '', 'total' => ''];
        $secondSemester = $grades['second_semester'] ?? ['p3' => '', 'p4' => '', 'exam' => '', 'total' => ''];
        $repechage = $grades['repechage'] ?? '';
        $percentage = $grades['percentage'] ?? '';
        $teacher = $grades['teacher'] ?? '';
        ?>
        <tr>
            <td class="subject-column"><?php echo htmlspecialchars($subject); ?></td>
            <td><?php echo htmlspecialchars($firstSemester['p1'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($firstSemester['p2'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($firstSemester['exam'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($firstSemester['total'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($secondSemester['p3'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($secondSemester['p4'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($secondSemester['exam'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($secondSemester['total'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($repechage); ?></td>
            <td><?php echo htmlspecialchars($percentage); ?></td>
            <td><?php echo htmlspecialchars($teacher); ?></td>
        </tr>
        <?php
    }
    
    /**
     * Méthode pour générer un PDF (à implémenter avec une librairie PDF)
     */
    public function generatePDF(): void {
        // À implémenter avec TCPDF, Dompdf ou une autre librairie
        // Cette méthode générerait un PDF du bulletin
    }
    
    /**
     * Méthode pour valider les données
     */
    public function validateData(): bool {
        $requiredFields = [
            'studentData' => ['nom', 'classe'],
            'schoolData' => ['ville', 'commune', 'ecole', 'code'],
            'academicData' => ['annee_scolaire']
        ];
        
        foreach ($requiredFields as $dataType => $fields) {
            foreach ($fields as $field) {
                if (empty($this->{$dataType}[$field])) {
                    return false;
                }
            }
        }
        
        return true;
    }
}

// Exemple d'utilisation de la classe
$studentData = [
    'nom' => 'KABILA TSHIMANGA',
    'fre' => 'M',
    'classe' => '2ème Scientifique'
];

$schoolData = [
    'ville' => 'RENI',
    'commune' => 'BURUGULU',
    'ecole' => 'INSTITUT BUNGUULU',
    'code' => '62024 / 101 / 01 / 1'
];

$academicData = [
    'annee_scolaire' => '2023 - 2024'
];

$gradesData = [
    'religion' => [
        'first_semester' => ['p1' => '15', 'p2' => '32', 'exam' => '68', 'total' => '115'],
        'second_semester' => ['p3' => '16', 'p4' => '34', 'exam' => '72', 'total' => '122'],
        'repechage' => '',
        'percentage' => '75',
        'teacher' => 'X'
    ],
    'education_civique' => [
        'first_semester' => ['p1' => '18', 'p2' => '35', 'exam' => '70', 'total' => '123'],
        'second_semester' => ['p3' => '17', 'p4' => '36', 'exam' => '74', 'total' => '127'],
        'repechage' => '',
        'percentage' => '78',
        'teacher' => 'X'
    ],
    'education_vie' => [
        'first_semester' => ['p1' => '16', 'p2' => '33', 'exam' => '69', 'total' => '118'],
        'second_semester' => ['p3' => '18', 'p4' => '35', 'exam' => '71', 'total' => '124'],
        'repechage' => '',
        'percentage' => '76',
        'teacher' => 'X'
    ],
    'francais' => [
        'first_semester' => ['p1' => '45', 'p2' => '88', 'exam' => '176', 'total' => '309'],
        'second_semester' => ['p3' => '48', 'p4' => '92', 'exam' => '184', 'total' => '324'],
        'repechage' => '',
        'percentage' => '82',
        'teacher' => 'X'
    ],
    'mexican' => [
        'first_semester' => ['p1' => '42', 'p2' => '85', 'exam' => '170', 'total' => '297'],
        'second_semester' => ['p3' => '44', 'p4' => '87', 'exam' => '174', 'total' => '305'],
        'repechage' => '',
        'percentage' => '79',
        'teacher' => 'X'
    ],
    'geographie' => [
        'first_semester' => ['p1' => '40', 'p2' => '82', 'exam' => '164', 'total' => '286'],
        'second_semester' => ['p3' => '43', 'p4' => '85', 'exam' => '170', 'total' => '298'],
        'repechage' => '',
        'percentage' => '77',
        'teacher' => 'X'
    ],
    'histoire' => [
        'first_semester' => ['p1' => '38', 'p2' => '78', 'exam' => '156', 'total' => '272'],
        'second_semester' => ['p3' => '41', 'p4' => '83', 'exam' => '166', 'total' => '290'],
        'repechage' => '',
        'percentage' => '75',
        'teacher' => 'X'
    ],
    'francais2' => [
        'first_semester' => ['p1' => '44', 'p2' => '90', 'exam' => '180', 'total' => '314'],
        'second_semester' => ['p3' => '46', 'p4' => '94', 'exam' => '188', 'total' => '328'],
        'repechage' => '',
        'percentage' => '81',
        'teacher' => 'X'
    ],
    'mathematique' => [
        'first_semester' => ['p1' => '35', 'p2' => '72', 'exam' => '144', 'total' => '251'],
        'second_semester' => ['p3' => '38', 'p4' => '76', 'exam' => '152', 'total' => '266'],
        'repechage' => '',
        'percentage' => '73',
        'teacher' => 'X'
    ]
];

$bulletin = new BulletinScolaireRDC($studentData, $schoolData, $academicData, $gradesData);

if ($bulletin->validateData()) {
    echo $bulletin->render();
} else {
    echo "Données incomplètes pour générer le bulletin.";
}


?>