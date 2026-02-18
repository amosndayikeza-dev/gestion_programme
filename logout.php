<?php
/**
 * Déconnexion simple
 */
session_start();
session_destroy();

// Rediriger vers la page de connexion avec message
header('Location: login.php?success=Vous+avez+été+déconnecté+avec+succès');
exit();
?>
