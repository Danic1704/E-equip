<?php
session_start();
include('connect.php'); // Connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur_id = $_SESSION['utilisateur_id'];
    $adresse_livraison = trim($_POST['adresse_livraison']);
    $montant_total = $_POST['montant_total'];
    $quantite = $_POST['quantite'];

    // Vérifier si les champs requis sont remplis
    if (empty($adresse_livraison) || empty($montant_total) || empty($quantite)) {
        $message = "Veuillez remplir tous les champs requis.";
    } else {
        // Insertion dans la table commandes
        $requete = $pdo->prepare("
            INSERT INTO commandes (utilisateur_id, quantite, date_commande, montant_total, adresse_livraison, statut)
            VALUES (:utilisateur_id, :quantite, NOW(), :montant_total, :adresse_livraison, 'En cours')
        ");

        $requete->bindParam(':utilisateur_id', $utilisateur_id);
        $requete->bindParam(':quantite', $quantite);
        $requete->bindParam(':montant_total', $montant_total);
        $requete->bindParam(':adresse_livraison', $adresse_livraison);

        if ($requete->execute()) {
            // Redirige vers la page de confirmation
            echo "<script>
                if (confirm('Votre commande a été validée avec succès. Souhaitez-vous consulter vos commandes maintenant ?')) {
                    window.location.href = 'mes_commandes.php';
                } else {
                    window.location.href = 'page_produits.php';
                }
            </script>";
            exit();
        } else {
            $message = "Erreur lors de la validation de la commande.";
        }
    }
}
?>