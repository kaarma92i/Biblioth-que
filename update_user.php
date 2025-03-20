<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Veuillez vous connecter");
}
$new_username = $_POST['username'];
$stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
$stmt->execute([$new_username, $_SESSION['user_id']]);
echo "Mise à jour réussie";
?>