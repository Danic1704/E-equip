<?php
// Inclure le fichier de connexion
include 'connect.php'; // Assurez-vous que ce fichier est correctement inclus

// Récupération de la catégorie à partir des paramètres GET
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';

// Initialisation de la variable $produits
$produits = [];

try {
    // Requête SQL pour récupérer les produits de la catégorie sélectionnée
    $sql = "SELECT * FROM produits WHERE categorie = :categorie";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['categorie' => $categorie]);
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gérer les erreurs de la requête SQL
    echo "Erreur lors de la récupération des produits : " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - <?php echo htmlspecialchars(ucfirst($categorie)); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        /* Style habituel avec animations */
body {
    font-family: 'Arial', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
    background: #f9f9f9;
}

.rubrique {
    text-align: center;
    font-size: 3rem; /* Réduit la taille de police pour éviter un espace excessif */
    color: #9f2d00;
    padding: 1rem;
    margin: 0; /* Réduit l'espace au-dessus et au-dessous de la rubrique */
    background: #c2c2d9;
    text-transform: none;
    font-family: 'Arial', sans-serif;
    border-bottom: 5px solid rgba(220, 82, 13, 0.3);
    animation: fadeInDown 1s ease-in-out;
}


@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 10px 20px; /* Ajuste le padding pour une meilleure présentation */
    margin-top: -20px; /* Réduit l'espace au-dessus de la liste des produits */
}

.product-card {
    background: #f0f0f0;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    padding: 15px;
    width: 300px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 350px; /* Réduire la hauteur */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin: 0;
}

.product-card a {
    text-decoration: none;
    color: inherit;
}

.product-card:hover {
    box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
}

.product-card img {
    max-width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.product-card:hover img {
    transform: scale(1.05);
}

.product-card h2 {
    font-size: 18px;
    margin: 10px 0;
    font-family: 'Verdana', sans-serif;
    color: #333;
    transition: color 0.3s ease;
}

.product-card:hover h2 {
    color: #dc520d;
}

.product-card p {
    font-size: 14px;
    color: #555;
    font-family: 'Georgia', serif;
    margin-bottom: 10px;
    line-height: 1.5;
    transition: color 0.3s ease;
}

.product-card:hover p {
    color: #333;
}

/* Pour les petits écrans (mobiles) */
@media screen and (max-width: 768px) {
    .product-card {
        width: 45%;
    }
}

/* Pour les très petits écrans (mobiles) */
@media screen and (max-width: 480px) {
    .product-card {
        width: 100%;
    }
}

.rubrique p.info-categorie {
    text-align: center; /* Centrer le texte */
    font-size: 1.8rem; /* Taille de police agréable à lire */
    color: #555; /* Couleur du texte */
    background: #fff; /* Fond blanc pour contraster avec la page */
    border: none; /* Bordure légère */
    border-radius: 8px; /* Coins arrondis */
    padding: 15px; /* Ajoute du padding pour une meilleure lisibilité */
    font-family: 'Georgia', serif; /* Police élégante */
    line-height: 1.6; /* Hauteur de ligne pour améliorer la lisibilité */
    margin: 10px 0; /* Ajoute une marge pour séparer les paragraphes */
}

p.info-categorie a {
    color: #dc520d; /* Couleur des liens */
    text-decoration: none; /* Supprimer la décoration des liens */
    font-weight: bold; /* Mettre en gras les liens */
}

p.info-categorie a:hover {
    text-decoration: underline; /* Souligner les liens au survol */
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

<div class="rubrique">
    <h1>Nos Meilleures Sélections</h1>
    <?php if (!empty($produits)): ?>
        <p class="info-categorie">Nous avons une sélection variée de produits dans la catégorie "<?php echo htmlspecialchars($categorie); ?>". Explorez notre gamme et trouvez ce qui correspond le mieux à vos besoins. Chaque produit a été soigneusement sélectionné pour vous offrir qualité et performance.</p>
    <?php else: ?>
        <p class="info-categorie">Actuellement, il n'y a aucun produit disponible dans la catégorie "<?php echo htmlspecialchars($categorie); ?>". Nous vous encourageons à revenir bientôt, car notre inventaire est régulièrement mis à jour. En attendant, n'hésitez pas à explorer d'autres catégories.</p>
    <?php endif; ?>
</div>
<main class="">
    <section class="product-container">
        <?php if (!empty($produits)): ?>
            <?php foreach ($produits as $produit): ?>
                <div class="product-card">
                    <a href="produit_détail.php?produit_id=<?php echo htmlspecialchars($produit['produit_id']); ?>">
                        <img src="<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                        <h2><?php echo htmlspecialchars($produit['nom']); ?></h2>
                        <p><strong>Prix :</strong> <?php echo htmlspecialchars($produit['prix']) ?> f</p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit trouvé dans cette catégorie.</p>
        <?php endif; ?>
    </section>
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
