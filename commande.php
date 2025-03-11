<?php
// Connexion à la base de données
include('connect.php');

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit();
}

// Vérifier si un produit a été sélectionné
if (!isset($_GET['produit_id']) || !is_numeric($_GET['produit_id'])) {
    error_log("Produit ID non valide.");
    header('Location: page_produits.php');
    exit();
}

$produit_id = intval($_GET['produit_id']); // Convertir en entier pour éviter les problèmes de type

// Utiliser le bon nom de colonne pour la requête SQL
try {
    $requete = $pdo->prepare("SELECT * FROM produits WHERE produit_id = :produit_id");
    $requete->bindParam(':produit_id', $produit_id, PDO::PARAM_INT);
    $requete->execute();
    $produit = $requete->fetch(PDO::FETCH_ASSOC);

    if (!$produit) {
        error_log("Produit non trouvé avec l'ID: $produit_id");
        header('Location: page_produits.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des informations du produit : " . $e->getMessage());
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande - E-equip</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<script>
        function confirmerCommande(event) {
            if (!confirm('Êtes-vous sûr de vouloir passer cette commande ?')) {
                event.preventDefault(); // Empêche la soumission du formulaire
            }
        }
    </script>
<style>
    body{
        background-color: #c2c2d9;
    }

/* Container principal */
.containers {
    margin: auto;
  
    flex-direction: column;
    align-items: center;
    gap: 20px;
    width: 100%;
    max-width: 560px;
    margin-bottom: 30px; 
}

/* Détails du produit */
.produit-details {
    text-align: center;
    max-width: 560px;
}

/* Styles du titre du produit */
.produit-details h3 {
    margin: 0;
    font-size: 20px;
    font-weight: bold;
    text-transform: none;
    margin-bottom: 10px;
}

/* Styles du paragraphe */
.produit-details p {
    margin-top: 10px;
    font-size: 16px;
}

/* Styles de l'image du produit */
.produit-details img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-top: 10px;
}
.containers img{
   display: flex;
    max-width: 200px;
    height: auto;
    border-radius: 8px;
    margin-top: 5px;
    margin-bottom: 10px;
}

/* Formulaire de commande */
.commande-form {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.8); /* Transparent avec fond blanc léger */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    width: 100%;
    max-width: 560px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Styles du titre du formulaire */
.commande-form h2 {
    text-align: center;
    margin-bottom: 20px;
    text-transform: none;
}

/* Styles des labels */
.commande-form label {
    display: block;
    margin-bottom: 8px;
}

/* Styles des champs du formulaire */
.commande-form input, .commande-form textarea, .commande-form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid black;
    border-radius: 4px;
    background: transparent;
    font-weight: bold;
}

/* Styles des boutons du formulaire */
.commande-form .bttn {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

/* Styles des boutons */
.commande-form .bttn button {
    flex: 1;
    padding: 10px;
    border: none;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
    border-radius: 5px;
}

/* Styles du bouton de soumission */
.commande-form .bttn button[type="submit"] {
    background-color:#e16500 ;
}

/* Styles du bouton de soumission au survol */
.commande-form .bttn button[type="submit"]:hover {
    background-color: orangered;
}

/* Styles du bouton de réinitialisation */
.commande-form .bttn button[type="reset"] {
    background-color: gray;
}

/* Styles du bouton de réinitialisation au survol */
.commande-form .bttn button[type="reset"]:hover {
    background-color: darkgray;
}

/* Styles responsifs */
@media (max-width: 768px) {
    .commande-form {
        padding: 15px;
        width: 90%;
    }
}

@media (max-width: 480px) {
    .commande-form {
        padding: 10px;
    }
}

/* Styles spécifiques pour la page de commande */
.quantity-container {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

/* Styles des boutons de quantité */
.quantity-btn {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background-color: #f1f1f1;
    text-align: center;
    line-height: 30px;
    cursor: pointer;
}

/* Styles des boutons de quantité au survol */
.quantity-btn:hover {
    background-color: #ddd;
}

/* Styles des zones de texte */
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid black;
    border-radius: 4px;
    background: transparent;
    font-weight: bold;
}
</style>
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
            <a href="#">Accueil</a>
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
            <a href="mes_commandes.php"><i class='bx bx-cart'></i></a>
        </div>
    </div>
</header>

<main>
    <div class="containers">
    <center><img src="<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>"></center>
    
        <div class="produit-details">
            
            <h3>Commander le produit : <?php echo htmlspecialchars($produit['nom']); ?></h3>
        </div>

        <div class="commande-form">
    <h2>Passer une commande</h2>
    <form action="valider_commande.php" method="post">
        <input type="hidden" name="produit_id" value="<?php echo htmlspecialchars($produit['produit_id']); ?>">
        
        <label for="quantite">Quantité:</label>
        <div class="quantity-container">
            <input type="number" name="quantite" id="quantite" value="1" min="1" required onchange="updateTotal()">
        </div>
        
        <label for="adresse_livraison">Adresse de Livraison :</label>
        <textarea id="adresse_livraison" name="adresse_livraison" rows="4" required></textarea>

        <label for="montant_total">Montant Total :</label>
        <input type="text" id="montant_total" name="montant_total" value="<?php echo htmlspecialchars(number_format($produit['prix'])); ?> f" readonly>

        <div class="bttn">
            <button type="submit">Passer la commande</button>
            <button type="reset">Réinitialiser</button>
        </div>
    </form>
</div>

<script>
    function updateTotal() {
        const quantite = document.getElementById('quantite').value;
        const prixUnitaire = <?php echo htmlspecialchars($produit['prix']); ?>;
        const montantTotal = quantite * prixUnitaire;

        document.getElementById('montant_total').value = montantTotal.toFixed() + " f";
    }
</script>

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
