<?php
session_start(); // Démarre la session

// Vérifie si une session est active
if (isset($_SESSION['utilisateur_id'])) {
    // Détruit toutes les variables de session
    $_SESSION = array();

    // Si un cookie de session existe, le supprimer
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Détruit la session
    session_destroy();

    // Redirige vers la page de connexion ou d'accueil
    header("Location: index.php"); 
    exit();
} else {
    // Si aucun utilisateur n'est connecté, rediriger directement
    header("Location: login.php"); 
    exit();
}
