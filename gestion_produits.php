<?php
// Inclure le fichier de connexion
include 'connect.php';

// Requête SQL pour récupérer les produits
$sql = "SELECT `produit_id`, `nom`, `description`, `prix`, `categorie`, `image`, `date_ajout`, `categorie_id` FROM `produits` WHERE 1";
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <link rel="stylesheet" href="style0.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script>
        // Fonction pour afficher les messages d'alerte
        function showAlert(message, type) {
            const color = type === 'success' ? 'green' : 'red';
            const alertBox = document.createElement('div');
            alertBox.style.backgroundColor = color;
            alertBox.style.color = 'white';
            alertBox.style.padding = '10px';
            alertBox.style.margin = '10px 0';
            alertBox.style.borderRadius = '5px';
            alertBox.textContent = message;
            document.body.insertBefore(alertBox, document.body.firstChild);
        }

        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            const type = urlParams.get('type');

            if (message && type) {
                showAlert(message, type);
            }
        }
    </script>
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
<h1 class="mot">Liste des Produits</h1>

    <main class="main">
        <section class="produits">
            <?php if ($stmt->rowCount() > 0): ?>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <article class="produit">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['nom']); ?>">
                        <h2><?php echo htmlspecialchars($row['nom']); ?></h2>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="prix"><?php echo htmlspecialchars($row['prix']); ?> f</p>
                        <p class="categorie">Catégorie: <?php echo htmlspecialchars($row['categorie']); ?></p>
                        <p class="date-ajout">Ajouté le: <?php echo htmlspecialchars(date('d/m/Y', strtotime($row['date_ajout']))); ?></p>
                        <div class="actions">
                            <a href="modifier_produit.php?id=<?php echo $row['produit_id']; ?>" class="btn btn-modifier">Modifier</a>
                            <a href="supprimer_produit.php?id=<?php echo $row['produit_id']; ?>" class="btn btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Aucun produit trouvé.</p>
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
