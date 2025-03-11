<?php
// Connection à la base de données
include 'connect.php';

// Vérification de la connexion PDO
if (!$pdo) {
    die("Erreur de connexion : " . $pdo->errorInfo());
}

$commande_id = isset($_GET['commande_id']) ? intval($_GET['commande_id']) : 0;

// Récupération des détails de la livraison
$sql = "SELECT * FROM livraisons WHERE commande_id = ?";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([$commande_id]);
    $livraison = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$livraison) {
        die("Aucune livraison trouvée pour l'ID de commande : $commande_id");
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération des détails de livraison : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de Livraison</title>
    <link rel="stylesheet" href="style0.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

       

         h1 {
            margin: 0;
            font-size: 2rem;
        }

        main {
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    max-width: 1200px;
    border: 1px solid #ddd;
    background-image: linear-gradient(to bottom, #f9f9f9, #ffffff);
}

main h2 {
    color: #333;
    font-size: 2rem;
    border-bottom: 2px solid #e16500;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

main p {
    background-color: #fff;
    padding: 15px;
    border: 1px solid #ddd;
    margin-bottom: 15px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-size: 1.2rem;
}


        h2 {
            color: #333;
            font-size: 1.8rem;
            border-bottom: 2px solid #e16500;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        @media (max-width: 768px) {
    main {
        padding: 15px;
        margin: 10px;
    }

    main h2 {
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    main p {
        padding: 10px;
        margin-bottom: 10px;
    }
}

@media (max-width: 480px) {
    main {
        padding: 10px;
        margin: 5px;
    }

    main h2 {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    main p {
        padding: 8px;
        margin-bottom: 8px;
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
            <a href="#"><i class='bx bx-cart'></i></a>
        </div>
    </div>
</header>

<main>
    <h2>Détails de la Livraison</h2>
    <p>ID Commande : <?php echo htmlspecialchars($livraison['commande_id']); ?></p>
    <p>Transporteur : <?php echo htmlspecialchars($livraison['transporteur']); ?></p>
    <p>Numéro de Suivi : <?php echo htmlspecialchars($livraison['num_suivi']); ?></p>
    <p>Date d'Expédition : <?php echo htmlspecialchars($livraison['date_expedition']); ?></p>
    <p>Date de Livraison : <?php echo htmlspecialchars($livraison['date_livraison']); ?></p>
    <p>Statut : <?php echo htmlspecialchars($livraison['status']); ?></p>
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
                    <li><a href="#">Points de Fidélité</a></li>
                    <li><a href="#">Mentions légales</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>À propos</h3>
                <ul>
                    <li><a href="#">SAV</a></li>
                    <li><a href="#">Services Clients</a></li>
                    <li><a href="#">Livraison et Retours</a></li>
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
