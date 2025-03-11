<?php
include 'connect.php';

// Récupérer toutes les commandes depuis la base de données
$sql = "SELECT commande_id, utilisateur_id, date_commande, montant_total, adresse_livraison, statut FROM commandes";
$result = $pdo->query($sql);

// Si une commande doit être marquée comme "Livrée"
if (isset($_POST['marquer_livree'])) {
    $commande_id = $_POST['commande_id'];
    $date_livraison = date('Y-m-d H:i:s'); // Enregistre la date et l'heure actuelles

    // Début de la transaction
    try {
        $pdo->beginTransaction();

        // Mettre à jour le statut de la livraison
        $sqlLivraison = "UPDATE livraisons 
                        SET date_livraison = :date_livraison, status = 'Livrée' 
                        WHERE commande_id = :commande_id";
        $stmtLivraison = $pdo->prepare($sqlLivraison);
        $stmtLivraison->execute(['date_livraison' => $date_livraison, 'commande_id' => $commande_id]);

        // Mettre à jour le statut de la commande
        $sqlCommande = "UPDATE commandes 
                        SET statut = 'Livrée' 
                        WHERE commande_id = :commande_id";
        $stmtCommande = $pdo->prepare($sqlCommande);
        $stmtCommande->execute(['commande_id' => $commande_id]);

        // Valider la transaction
        $pdo->commit();

        // Rediriger vers la page de gestion des commandes
        header('Location: gestion_des_commandes.php');
        exit();
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes</title>
    <link rel="stylesheet" href="style0.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
<header>
    <input type="checkbox" id="menu-toggle" class="menu-toggle">
    <label for="menu-toggle" class="bx bx-menu menu-icon"></label>
    <div class="container">
        <div class="logo">
            <video autoplay muted loop id="logo-video">
                <source src="images/E-.mp4" type="video/mp4">
                Votre navigateur ne prend pas en charge la vidéo.
            </video>
            <h1>E-equip</h1>
        </div>
        <nav class="navmenu">
            <a href="dashboard.php">Accueil</a>
            <a href="index.php#a-propos">À propos</a>
            <div class="nav-item">
                <a href="#">Catégories</a>
                <ul class="dropdown">
                    <li><a href="page_categorie.php?categorie=ordinateur">Ordinateur</a></li>
                    <li><a href="page_categorie.php?categorie=telephone">Téléphone</a></li>
                    <li><a href="page_categorie.php?categorie=peripherique">Périphérique</a></li>
                    <li><a href="page_categorie.php?categorie=accessoire">Composant PC</a></li>
                </ul>
            </div>
            <a href="contact.php">Contacts</a>
        </nav>
        <div class="nav-icons">
            <a href="login.php"><i class='bx bx-user-circle'></i></a>
            <a href=""><i class='bx bx-cart'></i></a>
        </div>
    </div>
</header>
<h1 class="mot">Gestion des Commandes</h1>
<div class="table-commande-container">
    <table class="table-commandes">
        <thead>
            <tr>
                <th>ID Commande</th>
                <th>ID Utilisateur</th>
                <th>Date Commande</th>
                <th>Montant Total</th>
                <th>Adresse Livraison</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->rowCount() > 0): ?>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['commande_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['utilisateur_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['date_commande']); ?></td>
                    <td><?php echo htmlspecialchars($row['montant_total']); ?></td>
                    <td><?php echo htmlspecialchars($row['adresse_livraison']); ?></td>
                    <td><?php echo htmlspecialchars($row['statut']); ?></td>
                    <td>
                        <?php if ($row['statut'] === 'En attente'): ?>
                            <form action="enregistrer_livraison.php" method="get">
                            <input type="hidden" name="commande_id" value="<?php echo htmlspecialchars($row['commande_id']); ?>">
                            <button type="submit" name="lancer_livraison" class="btn-livrer">Lancer la Livraison</button>
                        </form>
                        <?php elseif ($row['statut'] === 'En cours'): ?>
                            <span>En cours</span>
                        <?php else: ?>
                            <span>Livrée</span>
                        <?php endif; ?>
                        <a href="suivi_livraison.php?commande_id=<?php echo htmlspecialchars($row['commande_id']); ?>" class="btn-action-link">
                            <br><button class="btn-livrer">Suivre la Livraison</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Aucune commande trouvée</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-section logo-section">
                <div class="logo">
                    <video autoplay muted loop id="logo-video">
                        <source src="images/E-.mp4" type="video/mp4">
                        Votre navigateur ne prend pas en charge la vidéo.
                    </video>
                    <h1>E-equip</h1>
                </div>
            </div>
            <div class="footer-section">
                <h3>Liens Pratiques</h3>
                <ul>
                    <li><a href="">Points de Fidélité</a></li>
                    <li><a href="">Mentions légales</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>À propos</h3>
                <ul>
                    <li><a href="">SAV</a></li>
                    <li><a href="">Services Clients</a></li>
                    <li><a href="">Livraison et Retours</a></li>
                </ul>
            </div>
            <div class="footer-section newsletter-section">
                <h3>Newsletter</h3>
                <p>Découvrez en Avant Première Nos Tendances !</p>
                <input type="email" placeholder="Saisissez votre e-mail">
                <button>Transmettre</button>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Suivez-nous</p>
            <div class="social-icons">
                <a href="#" aria-label="Facebook" class="social-icon fa-brands fa-facebook"></a>
                <a href="#" aria-label="Twitter" class="social-icon fa-brands fa-twitter"></a>
                <a href="#" aria-label="Instagram" class="social-icon fa-brands fa-instagram"></a>
            </div>
            <p>&copy; 2024 E-equip. Tous droits réservés.</p>
        </div>
    </div>
</footer>
</body>
</html>
