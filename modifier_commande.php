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

try {
    // Récupérer les détails de la commande
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
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des détails de la commande : " . $e->getMessage());
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adresse_livraison = trim($_POST['adresse_livraison']);
    $quantite = $_POST['quantite'];

    if (empty($adresse_livraison) || empty($quantite)) {
        $message = "Veuillez remplir tous les champs requis.";
    } else {
        // Mettre à jour la commande
        try {
            $requete = $pdo->prepare("
                UPDATE commandes
                SET adresse_livraison = :adresse_livraison, quantite = :quantite
                WHERE commande_id = :commande_id AND utilisateur_id = :utilisateur_id
            ");
            $requete->bindParam(':adresse_livraison', $adresse_livraison);
            $requete->bindParam(':quantite', $quantite);
            $requete->bindParam(':commande_id', $commande_id);
            $requete->bindParam(':utilisateur_id', $utilisateur_id);
            if ($requete->execute()) {
                $message = "Commande mise à jour avec succès.";
                header('Location: mes_commandes.php');
                exit();
            } else {
                $message = "Erreur lors de la mise à jour de la commande.";
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de la commande : " . $e->getMessage());
            $message = "Erreur lors de la mise à jour de la commande.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Commande - E-equip</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        /* Ajoutez le CSS spécifique ici */
        .containers {
            width: 100%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 16px;
            color: #333;
        }

        input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #e16500;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: orangered;
        }

        p {
            text-align: center;
            font-size: 16px;
            color: #333;
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
        <div class="containers">
            <h1>Modifier Commande #<?php echo htmlspecialchars($commande['commande_id']); ?></h1>
            <form action="modifier_commande.php?commande_id=<?php echo htmlspecialchars($commande_id); ?>" method="post">
                <label for="quantite">Quantité:</label>
                <input type="number" name="quantite" id="quantite" value="<?php echo htmlspecialchars($commande['quantite']); ?>" min="1" required>

                <label for="adresse_livraison">Adresse de Livraison :</label>
                <textarea id="adresse_livraison" name="adresse_livraison" rows="4" required><?php echo htmlspecialchars($commande['adresse_livraison']); ?></textarea>

                <button type="submit">Mettre à Jour</button>
            </form>
            <?php if (isset($message)): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
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
