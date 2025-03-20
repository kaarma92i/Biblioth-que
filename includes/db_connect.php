<?php
$host = 'localhost';     // ou 127.0.0.1
$user = 'root';          // par défaut root
$password = '';          // vide si tu utilises XAMPP/WAMP, sinon ton mdp
$dbname = 'bibliotheque';

$link = mysqli_connect($host, $user, $password, $dbname);

if (!$link) {
    die('Erreur de connexion : ' . mysqli_connect_error());
} else {
    echo "Connexion à la base de données réussie!";
}
?>
