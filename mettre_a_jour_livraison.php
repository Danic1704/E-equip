<?php
// Connection à la base de données
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commande_id = $_POST['commande_id'];
    $status = $_POST['status'];

    // Mise à jour du statut de la livraison
    $sql = "UPDATE livraisons SET status = ?, modifie_le = NOW() WHERE commande_id = ?";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$status, $commande_id]);

        $message = urlencode("Le statut de la livraison a été mis à jour.");
    } catch (PDOException $e) {
        $message = urlencode("Erreur lors de la mise à jour : " . $e->getMessage());
    }

    header("Location: gestion_livraisons.php?message=$message");
    exit(); // Assurez-vous de terminer le script après la redirection
}
?>
