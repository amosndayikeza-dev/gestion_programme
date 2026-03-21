

    let menuprincipale = document.querySelector(".main-school-premium");

    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }
    
    const btnusertype=document.querySelectorAll(".btnUserType");
    console.log(btnusertype);

    document.querySelectorAll(".btnUserType").forEach(btn => {
    btn.addEventListener("click", function(e) {
        e.preventDefault();

        menuprincipale.style.display="none";
    });
    });

    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('userMenu');
        const button = event.target.closest('button[onclick="toggleUserMenu()"]');
        
        if (!button && menu && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
    
    // Alert functions
    function resolveAlert(action) {
        const actions = {
            'redémarrer': '🔧 Redémarrage du service en cours...',
            'renouveler': '📄 Ouverture du portail de licence...',
            'vérifier': '🔍 Vérification des paramètres...',
            'installer': '⬇️ Téléchargement de la mise à jour...'
        };
        
        const message = actions[action] || `Action "${action}" exécutée`;
        alert('⚙️ Résolution d\'alerte\n\n' + message);
    }
    
    // Quick action functions
    function addUser() {
        alert('👤 Ajouter un utilisateur\n\nOuverture du formulaire de création d\'utilisateur.');
    }
    
    function generateInvoice() {
        alert('🧾 Générer une facture\n\nSélectionnez le type de facture à générer.');
    }
    
    function generateReport() {
        alert('📊 Générer un rapport\n\nCréation d\'un rapport statistique détaillé.');
    }
    
    function systemSettings() {
        alert('⚙️ Paramètres système\n\nAccès aux paramètres avancés du système.');
    }
    
    function backupSystem() {
        alert('💾 Sauvegarde système\n\nLancement de la sauvegarde complète.');
    }
    
    function securityCheck() {
        alert('🛡️ Vérification sécurité\n\nAnalyse de sécurité en cours...');
    }
    
    function manageNotifications() {
        alert('🔔 Gestion notifications\n\nConfiguration des préférences de notification.');
    }
    
    function systemMaintenance() {
        alert('🔧 Maintenance système\n\nAccès aux outils de maintenance.');
    }
    
    // Progress bar animation
    document.querySelectorAll('.progress-fill').forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 300);
    });











    /*=======================================
    SCRIPT POUR UN SUBMENU = AJOUT UTILISATEUR 
    ==========================================*/

        const btn = document.getElementById("ajoutUtilisateur");
    const menu = document.getElementById("submenuProfil");
    

    btn.addEventListener("click", (e) => {
    e.stopPropagation();
    menu.classList.toggle("show");
    
    });

    // fermer si on clique ailleurs
    document.addEventListener("click", () => {
    menu.classList.remove("show");
    });
    






    document.getElementById("btnEtudiant").addEventListener("click", function(e){
    e.preventDefault(); // empêche le lien #

    const zone = document.getElementById("zoneFormulaire");

    // mettre le formulaire étudiant dans la zone
    zone.innerHTML = genererFormulaire('etudiant');

    // afficher la zone
    zone.style.display = "block";
    });


    document.getElementById("btnEnseignant").addEventListener("click", function(e){
    e.preventDefault(); // empêche le lien #

    const zone = document.getElementById("zoneFormulaire");

    // mettre le formulaire professeur dans la zone
    zone.innerHTML = genererFormulaire('professeur');

    // afficher la zone
    zone.style.display = "block";
    });


    
    document.getElementById("btnParent").addEventListener("click", function(e){
    e.preventDefault(); // empêche le lien #

    const zone = document.getElementById("zoneFormulaire");

    // mettre le formulaire parent dans la zone
    zone.innerHTML = genererFormulaire('parent');

    // afficher la zone
    zone.style.display = "block";
    });


        document.getElementById("btnTuteur").addEventListener("click", function(e){
    e.preventDefault(); // empêche le lien #

    const zone = document.getElementById("zoneFormulaire");

    // mettre le formulaire tuteur dans la zone
    zone.innerHTML = genererFormulaire('tuteur');

    // afficher la zone
    zone.style.display = "block";
    });



    document.getElementById("btnInspecteur").addEventListener("click", function(e){
    e.preventDefault(); // empêche le lien #

    const zone = document.getElementById("zoneFormulaire");

    // mettre le formulaire inspecteur dans la zone
    zone.innerHTML = genererFormulaire('inspecteur');

    // afficher la zone
    zone.style.display = "block";
    });

    

                    
    const labels = {
    etudiant: "étudiant",
    enseignant: "enseignant",
    prefet: "préfet",
    parent: "parent",
    inspecteur: "inspecteur",
    tuteur: "tuteur",
    titulaire: "titulaire"
    };
    
    
        let zoneFormulaire=document.getElementById("zoneFormulaire");
    
        let titre = document.getElementById("titreFormulaire");
        let retourner = document.getElementById("retourner");
        let containerTitre=document.getElementById("containerTitre")

        retourner.addEventListener("click", function () {
        // enlever la classe bootstrap qui bloque la couleur
        titre.classList.remove("bg-warning");

        containerTitre.style.display = "none";
        zoneFormulaire.style.display="none";



        menuprincipale.style.display="block";


        });
    
    

    document.querySelectorAll(".btnUserType").forEach(btn => {
    btn.addEventListener("click", function(e) {
        e.preventDefault();
        
        const containerTitre=document.getElementById("containerTitre")
        containerTitre.style.display="flex";

        const type = this.dataset.type;
        titre.textContent = "Ajouter un " + labels[type];
    });
    });

    
    console.log("voila le zoneFormulaire", zoneFormulaire);


