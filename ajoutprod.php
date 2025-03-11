<?php
// Inclure le fichier de connexion à la base de données
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['productName'] ?? '';
    $description = $_POST['productDescription'] ?? '';
    $prix = $_POST['productPrice'] ?? '';
    $categorieNom = $_POST['productCategory'] ?? '';

    // Vérifier si le fichier a été téléchargé
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['productImage']['name'];
        $imageTmpName = $_FILES['productImage']['tmp_name'];
        $target_dir = "images/";
        
        // Générer un nom de fichier unique
        $uniqueName = time() . '-' . basename($image);
        $target_file = $target_dir . $uniqueName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Vérifier si le fichier est une image réelle ou une fausse image
        $check = getimagesize($imageTmpName);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
        
        // Limiter la taille du fichier (par exemple, 5MB maximum)
        if ($_FILES["productImage"]["size"] > 5000000) {
            echo "Désolé, votre fichier est trop grand.";
            $uploadOk = 0;
        }
        
        // Autoriser certains formats de fichier
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
            $uploadOk = 0;
        }

        // Préparer et exécuter la requête SQL pour obtenir l'ID de la catégorie
        $sql = "SELECT categorie_id FROM categories WHERE nom = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$categorieNom]);
        $categorie = $stmt->fetch();

        // Vérifier si une catégorie a été trouvée
        if ($categorie) {
            $categorie_id = $categorie['categorie_id'];
        } else {
            echo "Catégorie non trouvée.";
            exit();
        }

        // Vérifier si $uploadOk est mis à 0 par une erreur
        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été téléchargé.";
        } else {
            if (move_uploaded_file($imageTmpName, $target_file)) {
                // Préparer et exécuter la requête SQL pour insérer le produit
                $sql = "INSERT INTO produits (nom, description, prix, categorie, image, date_ajout, categorie_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)";
                $stmt = $pdo->prepare($sql);

                if ($stmt->execute([$nom, $description, $prix, $categorieNom, $target_file, $categorie_id])) {
                    // Afficher une alerte JavaScript et rediriger vers la page des produits
                    echo "<script>
                        alert('Le produit a été ajouté avec succès !');
                        window.location.href = 'dashboard.php';
                    </script>";
                } else {
                    echo "Erreur lors de l'ajout du produit.";
                }

            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        }
    } else {
        if (isset($_FILES['productImage'])) {
            // Afficher des messages d'erreur pour les codes d'erreur de téléchargement
            $uploadErrorMessages = [
                UPLOAD_ERR_INI_SIZE => 'Le fichier dépasse la taille maximale autorisée dans php.ini.',
                UPLOAD_ERR_FORM_SIZE => 'Le fichier dépasse la taille maximale spécifiée dans le formulaire HTML.',
                UPLOAD_ERR_PARTIAL => 'Le fichier a été téléchargé seulement partiellement.',
                UPLOAD_ERR_NO_FILE => 'Aucun fichier n\'a été téléchargé.',
                UPLOAD_ERR_NO_TMP_DIR => 'Un dossier temporaire est manquant.',
                UPLOAD_ERR_CANT_WRITE => 'Échec de l\'écriture du fichier sur le disque.',
                UPLOAD_ERR_EXTENSION => 'Un arrêt du téléchargement a été causé par une extension PHP.'
            ];
            $errorCode = $_FILES['productImage']['error'];
            echo "Erreur de téléchargement : " . ($uploadErrorMessages[$errorCode] ?? 'Erreur inconnue.');
        } else {
            echo "Aucun fichier image téléchargé.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
            background-color: #4d5880; /* Fond de la page */
            color: #333;
            background-size: cover;
            margin: 0;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff; /* Optionnel : couleur de fond du conteneur principal */
            box-sizing: border-box;
            background: transparent;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
            color: #fff;
            text-transform: none;
        }

        form {
            max-width: 100%;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            background: transparent;
            backdrop-filter: blur(19px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            backdrop-filter: blur(8px);
            box-sizing: border-box;
        }

        form label {
            display: block;
            margin-top: 10px;
            font-size: 1.5rem;
            color: #fff; /* Assure la lisibilité des labels */
            text-decoration: none;
        }

        form input, 
        form textarea, 
        form select {
            width: 100%;
            padding: 10px;
            color: #333;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.9); /* Transparence des champs de formulaire */
            font-size: 1.4rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
            text-transform: none;
        }

        form input::placeholder, 
        form textarea::placeholder {
            color: #aaa;
        }

        form input:focus, 
        form textarea:focus, 
        form select:focus {
            border-color: #e16500;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            color: #333;
            text-transform: none;
        }

        form button {
            margin-top: 20px;
            padding: 10px 20px;
            align-items: center;
            margin: 5px;
            background-color: #e16500;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.3rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        form button:hover {
            background-color: #d15400;
            transform: translateY(-3px);
        }

        /* Media Queries */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }

            form {
                padding: 15px;
            }

            form label {
                font-size: 1.1rem;
            }

            form input, form textarea, form select {
                font-size: 1.1rem;
            }

            form button {
                font-size: 1.2rem;
                padding: 10px 15px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.5rem;
            }

            form {
                padding: 10px;
            }

            form label {
                font-size: 1rem;
            }

            form input, form textarea, form select {
                font-size: 1rem;
            }

            form button {
                font-size: 1.1rem;
                padding: 10px 12px;
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
            <a href=""><i class='bx bx-cart'></i></a>
        </div>
    </div>
</header>

<main>
    <h1>Ajouter un Produit</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="productName">Nom du produit :</label>
        <input type="text" id="productName" name="productName" required placeholder="Entrez le nom du produit">

        <label for="productDescription">Description :</label>
        <textarea id="productDescription" name="productDescription" rows="4" required placeholder="Entrez une description du produit"></textarea>

        <label for="productPrice">Prix :</label>
        <input type="number" id="productPrice" name="productPrice" required placeholder="Entrez le prix du produit">

        <label for="productCategory">Catégorie :</label>
        <select id="productCategory" name="productCategory" required>
            <option value="" disabled selected>Choisissez une catégorie</option>
            <?php
            // Récupérer les catégories depuis la base de données
            $sql = "SELECT nom FROM categories";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                echo "<option value='" . htmlspecialchars($row['nom']) . "'>" . htmlspecialchars($row['nom']) . "</option>";
            }
            ?>
        </select>

        <label for="productImage">Image :</label>
        <input type="file" id="productImage" name="productImage" accept="image/*" required>

        <button type="submit">Ajouter le produit</button>
    </form>
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
