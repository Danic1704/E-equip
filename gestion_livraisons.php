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

// Affichage des messages d'alerte
if (isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
    echo "<script>alert('$message');</script>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Livraisons</title>
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

<h1 class="mot">Gestion des Livraisons</h1>

<div class="table-commande-container">
    <table class="table-commandes">
        <thead>
            <tr>
                <th>ID Commande</th>
                <th>Date Commande</th>
                <th>Date Expédition</th>
                <th>Date Livraison</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            try {
                // Requête SQL pour récupérer les commandes avec les informations de livraison si elles existent
                $sql = "SELECT c.commande_id, c.date_commande, l.date_expedition, l.date_livraison, COALESCE(l.status, 'En cours') as status 
                        FROM commandes c
                        LEFT JOIN livraisons l ON c.commande_id = l.commande_id";

                $result = $pdo->query($sql);

                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['commande_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['date_commande']) . '</td>';
                        echo '<td>' . (isset($row['date_expedition']) ? htmlspecialchars($row['date_expedition']) : 'Non encore expédié') . '</td>';
                        echo '<td>' . (isset($row['date_livraison']) ? htmlspecialchars($row['date_livraison']) : 'Non encore livré') . '</td>';
                        echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                        echo '<td>';
                        if ($row['status'] == 'En cours') {
                            echo '<a href="marquer_livrer.php?commande_id=' . htmlspecialchars($row['commande_id']) . '" class="btn-livrer">Marquer comme Livré</a>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">Aucune commande</td></tr>';
                }
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
        ?>
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

<?php
// Fermer la connexion PDO
$pdo = null;
?>
