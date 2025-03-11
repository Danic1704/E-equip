<?php
// Inclure le fichier de connexion
include 'connect.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];
    $image = $_POST['image'];

    // Requête pour mettre à jour le produit
    $sql = "UPDATE `produits` SET `nom` = :nom, `description` = :description, `prix` = :prix, `categorie` = :categorie, `image` = :image WHERE `produit_id` = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':description' => $description,
        ':prix' => $prix,
        ':categorie' => $categorie,
        ':image' => $image,
        ':id' => $id
    ]);

    // Redirection avec message de succès
    header("Location: gestion_produits.php?message=Produit modifié avec succès&type=success");
    exit();
}

// Récupérer les détails du produit
$id = $_GET['id'];
$sql = "SELECT * FROM `produits` WHERE `produit_id` = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les catégories
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="style0.css">
    <script>
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

<h1 class="mot">Modifier le Produit</h1>
    <main class="mains">
    <form action="modifier_produit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($produit['produit_id']); ?>">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($produit['nom']); ?>" required>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($produit['description']); ?></textarea>
            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" value="<?php echo htmlspecialchars($produit['prix']); ?>" required>
            <label for="categorie">Catégorie :</label>
            <select id="categorie" name="categorie" required>
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?php echo htmlspecialchars($categorie['categorie_id']); ?>" <?php echo $produit['categorie_id'] == $categorie['categorie_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($categorie['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="image">URL de l'image :</label>
            <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($produit['image']); ?>">
            <label for="image_file">Télécharger une nouvelle image :</label>
            <input type="file" id="image_file" name="image_file" accept="image/*">
            <button type="submit">Enregistrer</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Votre Entreprise</p>
    </footer>
</body>
</html>
