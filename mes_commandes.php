<?php
session_start();
include('connect.php'); // Connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit();
}

$utilisateur_id = $_SESSION['utilisateur_id'];

// Récupérer les commandes de l'utilisateur
try {
    $requete = $pdo->prepare("
        SELECT * FROM commandes
        WHERE utilisateur_id = :utilisateur_id
        ORDER BY date_commande DESC
    ");
    $requete->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
    $requete->execute();
    $commandes = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des commandes : " . $e->getMessage());
    $commandes = [];
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Commandes - E-equip</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        /* Styles spécifiques pour la page de mes commandes */
        .commandes-container {
            width: 100%;
            max-width: 800px;
            margin: 5px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .commandes-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #e16500;
        }

        .commande {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .commande:last-child {
            border-bottom: none;
        }

        .commande h2 {
            font-size: 18px;
            margin: 0 0 10px;
        }

        .commande p {
            margin: 5px 0;
            font-size: 16px;
        }

        .commande .date {
            font-style: italic;
        }

        .commande-actions {
            margin-top: 10px;
            font-size: 15px;
        }

        .commande-actions a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            margin-right: 10px;
        }

        .commande-actions a:hover {
            text-decoration: underline;
            color: #e16500;
        }
    </style>
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
            <a href="index.php">Accueil</a>
            <a href="index.php#a-propos">À propos</a>
            <div class="nav-item">
                <a href="contact.php">Catégories</a>
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
            <a href="mes_commandes.php"><i class='bx bx-cart'></i></a>
        </div>
    </div>
</header>

    <main>
        <div class="commandes-container">
            <h1>Mes Commandes</h1>
            <?php if (!empty($commandes)): ?>
                <?php foreach ($commandes as $commande): ?>
                    <div class="commande">
                        <h2>Commande #<?php echo htmlspecialchars($commande['commande_id']); ?></h2>
                        <p class="date">Date de commande : <?php echo htmlspecialchars(date('d-m-Y H:i', strtotime($commande['date_commande']))); ?></p>
                        <p>Quantité : <?php echo htmlspecialchars($commande['quantite']); ?></p>
                        <p>Montant Total : <?php echo htmlspecialchars(number_format($commande['montant_total'])); ?> f</p>
                        <p>Adresse de Livraison : <?php echo htmlspecialchars($commande['adresse_livraison']); ?></p>
                        <div class="commande-actions">
                            <a href="modifier_commande.php?commande_id=<?php echo htmlspecialchars($commande['commande_id']); ?>">Modifier</a>
                            <a href="annuler_commande.php?commande_id=<?php echo htmlspecialchars($commande['commande_id']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?');">Annuler</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune commande trouvée.</p>
            <?php endif; ?>
        </div>
    </main>
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
