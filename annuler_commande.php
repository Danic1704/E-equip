<?php
session_start();
include('connect.php'); // Connexion à la base de données

if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['commande_id']) || !is_numeric($_GET['commande_id'])) {
    header('Location: mes_commandes.php');
    exit();
}

$commande_id = intval($_GET['commande_id']);
$utilisateur_id = $_SESSION['utilisateur_id'];

// Confirmer que la commande existe et appartient à l'utilisateur
try {
    $requete = $pdo->prepare("
        SELECT * FROM commandes
        WHERE commande_id = :commande_id AND utilisateur_id = :utilisateur_id
    ");
    $requete->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);
    $requete->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
    $requete->execute();
    $commande = $requete->fetch(PDO::FETCH_ASSOC);

    if (!$commande) {
        header('Location: mes_commandes.php');
        exit();
    }

    // Annuler la commande
    $requete = $pdo->prepare("
        DELETE FROM commandes
        WHERE commande_id = :commande_id AND utilisateur_id = :utilisateur_id
    ");
    $requete->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);
    $requete->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);

    if ($requete->execute()) {
        header('Location: mes_commandes.php');
        exit();
    } else {
        $message = "Erreur lors de l'annulation de la commande.";
    }
} catch (PDOException $e) {
    error_log("Erreur lors de l'annulation de la commande : " . $e->getMessage());
    $message = "Erreur lors de l'annulation de la commande.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuler Commande - E-equip</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="E-equip">
        </div>
        <nav class="navmenu">
            <a href="page_accueil.php">Accueil</a>
            <a href="page_produits.php">Produits</a>
            <a href="mes_commandes.php">Mes Commandes</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h1>Annuler Commande #<?php echo htmlspecialchars($commande_id); ?></h1>
            <p>Êtes-vous sûr de vouloir annuler cette commande ?</p>
            <form action="annuler_commande.php?commande_id=<?php echo htmlspecialchars($commande_id); ?>" method="post">
                <button type="submit">Confirmer</button>
                <a href="mes_commandes.php">Annuler</a>
            </form>
            <?php if (isset($message)): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
