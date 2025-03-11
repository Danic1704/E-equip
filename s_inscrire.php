<?php
session_start();
include('connect.php'); // Connexion à la base de données

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = trim($_POST['s_nom_utilisateur']);
    $email = trim($_POST['s_email']);
    $password = $_POST['s_password'];
    $confirm_password = $_POST['s_confirm_password'];
    $profil = $_POST['s_profil'] ?? 'client'; // Récupère le profil (client par défaut si non défini)

    // Vérifier si les champs sont vides
    if (empty($nom_utilisateur) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "Veuillez remplir tous les champs.";
    } elseif ($password !== $confirm_password) {
        $message = "Les mots de passe ne sont pas identiques.";
    } else {
        // Vérifier si l'email existe déjà
        $requete = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = :email");
        $requete->bindParam(':email', $email);
        $requete->execute();
        
        if ($requete->rowCount() > 0) {
            $message = "Ce compte existe déjà.";
        } else {
            // Hacher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer dans la base de données
            $requete = $pdo->prepare("INSERT INTO Utilisateurs (nom_utilisateur, email, mot_de_passe, profil) VALUES (:nom_utilisateur, :email, :mot_de_passe, :profil)");
            $requete->bindParam(':nom_utilisateur', $nom_utilisateur);
            $requete->bindParam(':email', $email);
            $requete->bindParam(':mot_de_passe', $hashedPassword);
            $requete->bindParam(':profil', $profil);

            if ($requete->execute()) {
                $message = "Inscription réussie.";
                header('Location: login.php'); // Rediriger vers la page de connexion
                exit();
            } else {
                $message = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
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
            <h2>Inscription</h2>
            <?php if (!empty($message)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form action="s_inscrire.php" method="post">
                <label for="s_nom_utilisateur">Nom d'utilisateur :</label>
                <input type="text" id="s_nom_utilisateur" name="s_nom_utilisateur" required>

                <label for="s_email">Email :</label>
                <input type="email" id="s_email" name="s_email" required>

                <label for="s_password">Mot de passe :</label>
                <input type="password" id="s_password" name="s_password" required>

                <label for="s_confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="s_confirm_password" name="s_confirm_password" required>

                <!-- Champ pour le profil -->
                <input type="hidden" name="s_profil" value="client">

                <button type="submit" class="btn">S'inscrire</button>
            </form>

            <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
        </div>
    </main>
</body>
</html>
 