<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'e-equip';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$dsn = "mysql:host=$host;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_GET['commande_id'])) {
    $commande_id = $_GET['commande_id'];

    try {
        // Début de la transaction
        $pdo->beginTransaction();

        // Mettre à jour le statut de la livraison
        $sqlLivraison = "UPDATE livraisons SET status = 'Livré', date_livraison = NOW() WHERE commande_id = :commande_id";
        $stmtLivraison = $pdo->prepare($sqlLivraison);
        $stmtLivraison->execute(['commande_id' => $commande_id]);

        // Mettre à jour le statut de la commande
        $sqlCommande = "UPDATE commandes SET statut = 'Livré' WHERE commande_id = :commande_id";
        $stmtCommande = $pdo->prepare($sqlCommande);
        $stmtCommande->execute(['commande_id' => $commande_id]);

        // Valider la transaction
        $pdo->commit();

        // Redirection avec message de succès
        header("Location: gestion_livraisons.php?message=" . urlencode("Commande marquée comme livrée."));
        exit();
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        
        // Redirection avec message d'erreur
        header("Location: gestion_livraisons.php?message=" . urlencode("Erreur : " . $e->getMessage()));
        exit();
    }
} else {
    // Redirection avec message d'erreur si ID non fourni
    header("Location: gestion_livraisons.php?message=" . urlencode("ID de commande non fourni."));
    exit();
}

// Fermer la connexion PDO
$pdo = null;
?>
