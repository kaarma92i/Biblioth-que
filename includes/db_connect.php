<?php
$host = 'localhost';     
$user = 'root';          
$password = '';         
$dbname = 'bibliotheque';

$link = mysqli_connect($host, $user, $password, $dbname);

if (!$link) {
    die('Erreur de connexion : ' . mysqli_connect_error());
} else {
    echo "Connexion à la base de données réussie!";
}
?>
