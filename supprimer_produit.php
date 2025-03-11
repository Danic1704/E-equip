<?php
// Inclure le fichier de connexion
include 'connect.php';

$id = $_GET['id'];

// Requête pour supprimer le produit
$sql = "DELETE FROM `produits` WHERE `produit_id` = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);

// Redirection avec message de succès
header("Location: gestion_produits.php?message=Produit supprimé avec succès&type=success");
exit();
?>
