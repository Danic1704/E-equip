<?php
// Inclure le fichier de connexion
include 'connect.php';

// Récupération de l'ID du produit à partir des paramètres GET
$produit_id = isset($_GET['produit_id']) ? intval($_GET['produit_id']) : 0;

if ($produit_id > 0) {
    try {
        // Requête SQL pour récupérer les informations du produit
        $sql = "SELECT * FROM produits WHERE produit_id = :produit_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['produit_id' => $produit_id]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        // Requête pour récupérer les produits similaires (3 maximum)
        $sql_similaires = "SELECT * FROM produits WHERE categorie = :categorie AND produit_id != :produit_id LIMIT 3";
        $stmt_similaires = $pdo->prepare($sql_similaires);
        $stmt_similaires->execute(['categorie' => $produit['categorie'], 'produit_id' => $produit_id]);
        $produits_similaires = $stmt_similaires->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des données : " . $e->getMessage();
    }
} else {
    echo "Produit non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produit['nom']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        /* Styles pour la page de détail du produit */
        .product-detail-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            padding: 50px;
            gap: 20px;
            
        }

        .product-image {
            max-width: 50%;
            flex: 1;
        }

        .product-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-info {
            flex: 2;
            max-width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-info h1 {
            font-size: 2.4rem;
            color: #333;
            margin-bottom: 10px;
            font-family: 'Arial', sans-serif;
        }

        .product-info p {
            font-size: 1.6rem;
            color: #555;
            line-height: 1.5;
            margin-bottom: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .product-info strong {
            color: #333;
        }

        .product-info .btn-acheter {
            display: inline-block;
            padding: 12px 30px;
            font-size: 18px;
            color: #fff;
            background-color: #dc520d;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            align-self: center;
        }

        .product-info .btn-acheter:hover {
            background-color: #b8430b;
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .product-info .btn-acheter:active {
            transform: scale(0.95);
        }

        .delivery-options {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: 70px;
        }

        .delivery-options .option {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .delivery-options .option i {
            font-size: 24px;
            color: #dc520d;
        }

        .delivery-options .option p {
            font-size: 1.4rem;
            color: #555;
            margin: 0;
        }

        .similar-products {
            margin-top: 40px;
        }

        .similar-products h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            align-items: center;
            text-align: center;
        }

        .similar-products .product-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .similar-products .product-card {
            background: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
            width: 120px;
            text-align: center;
            transition: box-shadow 0.3s ease;
        }

        .similar-products .product-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .similar-products .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            cursor: pointer;
        }

        .similar-products .product-card h3 {
            font-size: 1.2rem;
            color: #333;
            margin: 5px 0;
        }

        .similar-products .product-card p {
            font-size: 1rem;
            color: #555;
        }

        @media screen and (max-width: 768px) {
            .product-detail-container {
                flex-direction: column;
                align-items: center;
            }

            .product-image, .product-info {
                max-width: 100%;
            }

            .similar-products .product-container {
                flex-direction: column;
                align-items: center;
            }
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
                <a href="#">Catégories</a>
                <ul class="dropdown">
                    <li><a href="page_categorie.php?categorie=ordinateur">Ordinateur</a></li>
                    <li><a href="page_categorie.php?categorie=telephone">Téléphone</a></li>
                    <li><a href="page_categorie.php?categorie=peripherique">Périphérique</a></li>
                    <li><a href="page_categorie.php?categorie=composant">Composant PC</a></li>
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
<main class="product-detail-container">
    <div class="product-image">
        <img src="<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
    </div>
    <div class="product-info">
        <h1><?php echo htmlspecialchars($produit['nom']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($produit['description'])); ?></p>
        <p><strong>Prix :</strong> <?php echo htmlspecialchars($produit['prix']); ?> f</p>
        <a href="commande.php?produit_id=<?php echo htmlspecialchars($produit['produit_id']); ?>" class="btn-acheter">Acheter</a>
         <!-- Options de livraison et retour -->
         <div class="delivery-options">
            <div class="option">
                <i class='bx bxs-truck'></i>
                <p>Livraison gratuite à partir de 50€</p>
            </div>
            <div class="option">
                <i class="bx bx-refresh"></i>
                <p>Retour sous 30 jours</p>
            </div>
        </div>
    </div>
</main>

<!-- Produits similaires -->
<div class="similar-products">
    <h2>Produits Similaires</h2>
    <div class="product-container">
        <?php if (!empty($produits_similaires)): ?>
            <?php foreach ($produits_similaires as $produit_similaire): ?>
                <a href="produit_détail.php?produit_id=<?php echo htmlspecialchars($produit_similaire['produit_id']); ?>">
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($produit_similaire['image']); ?>" alt="<?php echo htmlspecialchars($produit_similaire['nom']); ?>">
                    </div>
                </a>
                
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit similaire trouvé.</p>
        <?php endif; ?>
    </div>
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
