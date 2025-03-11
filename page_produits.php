<?php
// Connexion à la base de données
include('connect.php');

// Récupérer tous les produits de la base de données
$requete = $pdo->query("SELECT * FROM produits");
$produits = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style habituel avec animations */
        .rubrique {
            text-align: center;
            font-size: 4rem;
            color: rgb(220, 82, 13);
            padding: 1rem;
            margin: 2rem 0;
            background: #fff;
            text-transform: none;
            font-family: 'Arial', sans-serif; /* Ajoute une belle police de caractères */
            border-bottom: 5px solid rgba(220, 82, 13, 0.3); /* Ligne décorative en bas */
            animation: fadeInDown 1s ease-in-out; /* Animation d'apparition */
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
            padding: 20px;
        }

        .product-card {
            background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    padding: 15px; /* Réduit le padding pour diminuer la hauteur */
    width: 300px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Effet de survol */
    position: relative;
    overflow: hidden;
    /* Ajustement de la hauteur */
    height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
        }

        .product-card:hover {
            /*transform: translateY(-10px); /* Effet de survol pour soulever la carte */
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2); /* Accentuer l'ombre lors du survol */
        }

        .product-card img {
            max-width: 100%;
    height: 200px; /* Réduit la hauteur de l'image */
    object-fit: cover; /* Maintient l'aspect de l'image */
    border-radius: 12px;
    transition: transform 0.3s ease; /* Effet de zoom sur l'image */
        }

        .product-card:hover img {
            transform: scale(1.05); /* Zoomer légèrement l'image lors du survol */
        }

        .product-card h2 {
            font-size: 20px;
            margin: 10px 0;
            font-family: 'Verdana', sans-serif; /* Police élégante pour le titre */
            color: #333;
            transition: color 0.3s ease;
        }

        .product-card:hover h2 {
            color: #dc520d; /* Changer la couleur du titre lors du survol */
        }

        .product-card p {
            font-size: 16px;
            color: #555;
            font-family: 'Georgia', serif; /* Police pour un texte plus raffiné */
            margin-bottom: 5px;
            line-height: 1.5;
            transition: color 0.3s ease;
        }

        .product-card:hover p {
            color: #333; /* Assombrir le texte lors du survol */
        }

        .btn-commander {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 5px;
            font-size: 18px;
            color: #fff;
            background-color: #dc520d;
            border: none;
            border-radius: 30px; /* Boutons plus arrondis */
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease; /* Ajouter une animation de clic */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-commander:hover {
            background-color: #b8430b;
            transform: scale(1.05); /* Légère mise à l'échelle lors du survol */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .btn-commander:active {
            transform: scale(0.95); /* Effet de clic */
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
            <a href="dashboard.php">Accueil</a>
            <a href="#a-propos">À propos</a>
            <a href="#">Produits</a>
            <a href="#">Contacts</a>
        </nav>
        <div class="nav-icons">
            <a href="login.php"><i class='bx bx-user-circle'></i></a>
            <a href="#"><i class='bx bx-cart'></i></a>
        </div>
    </div>
</header>
    <h1 class="rubrique">Nos Produits</h1>
    <div class="product-container">
    <?php foreach ($produits as $produit): ?>
        <div class="product-card">
            <img src="<?php echo htmlspecialchars($produit['image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($produit['nom'] ?? 'Produit'); ?>">
            <h2><?php echo htmlspecialchars($produit['nom'] ?? 'Nom du produit'); ?></h2>
            <p class="description"><?php echo !empty($produit['description']) ? htmlspecialchars($produit['description']) : 'Description non disponible'; ?></p>
            <p><?php echo number_format($produit['prix'] ?? 0, 2); ?> €</p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
