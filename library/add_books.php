<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Veuillez vous connecter");
}
$book_id = $_POST['book_id'];
$title = $_POST['title'];
$stmt = $pdo->prepare("INSERT INTO books (user_id, book_id, title) VALUES (?, ?, ?)");
$stmt->execute([$_SESSION['user_id'], $book_id, $title]);
echo "Livre ajouté";
?>