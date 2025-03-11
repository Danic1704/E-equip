<?php
// Démarrer la session
session_start();

// Connexion à la base de données
$host = 'localhost';
$dbname = 'e-equip';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Variable pour les messages d'erreur
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Rechercher l'utilisateur dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Connexion réussie
        // Si l'authentification réussit, enregistrer l'ID de l'utilisateur dans la session
        $_SESSION['utilisateur_id'] = $user['utilisateur_id']; // Assurez-vous que $user['utilisateur_id'] contient l'ID de l'utilisateur
        $_SESSION['nom_utilisateur'] = $user['nom_utilisateur']; // Stocker le nom de l'utilisateur en session
        $_SESSION['profil'] = $user['profil']; // Stocker le profil de l'utilisateur en session

        // Message d'alerte JS pour indiquer la réussite
        echo "<script type='text/javascript'>
                alert('Connexion réussie !');
                window.location.href = '" . ($user['profil'] === 'administrateur' ? 'dashboard.php' : 'index.php') . "';
              </script>";
        exit(); // Assurer l'arrêt du script après redirection
    } else {
        // Échec de la connexion
        $error_message = "Email ou mot de passe incorrect.";
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        footer {
            text-align: center;
            padding: 20px;
            background-color: #2b2020;
            color: #e16500;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0; /* S'assurer que le footer couvre toute la largeur */
        }

        footer a {
            color: #e16500;
            text-decoration: none;
            font-size: 1.4rem;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="form-page">

    <main>
        <div class="form-container">
            <div class="logo">
                <video autoplay muted loop id="logo-video">
                    <source src="images/E-.mp4" type="video/mp4">
                    Votre navigateur ne prend pas en charge la vidéo.
                </video>
                <h1>E-equip</h1>
            </div>
            <h2>Connexion</h2>
            <?php if ($error_message): ?>
                <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <button type="submit" class="btn">Se connecter</button>
            </form>
            <p>Pas encore inscrit ? <a href="s_inscrire.php">Créer un compte</a></p>
        </div>
    </main>

    <footer>
        <a href="index.php">Retour à l'accueil</a>
    </footer>

</body>
</html>
