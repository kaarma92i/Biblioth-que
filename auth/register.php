<?php
// Démarrer la session si nécessaire
session_start();

// Initialisation des variables pour éviter les erreurs "Undefined variable"
$username = "";
$username_err = "";
$password = "";
$password_err = "";
$confirm_password = "";
$confirm_password_err = "";

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du nom d'utilisateur
    if (empty(trim($_POST["username"]))) {
        $username_err = "Veuillez entrer un nom d'utilisateur.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Vérification du mot de passe
    if (empty(trim($_POST["password"]))) {
        $password_err = "Veuillez entrer un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Vérification de la confirmation du mot de passe
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Veuillez confirmer le mot de passe.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password !== $confirm_password)) {
            $confirm_password_err = "Les mots de passe ne correspondent pas.";
        }
    }

    // Si pas d'erreurs, insérer dans la base de données
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        // Connexion à la base de données
        $conn = new mysqli('localhost', 'root', '', 'bibliotheque');
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Préparer la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        // Exécuter la requête
        if ($stmt->execute()) {
            // Redirection après l'inscription réussie
            $_SESSION['username'] = $username;
            header("Location: welcome.php"); // Rediriger vers une page de bienvenue ou autre
            exit();
        } else {
            echo "Erreur d'inscription : " . $stmt->error;
        }

        // Fermer la connexion
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="http://localhost:8000/css/register.css">
</head>
<body>
    <h2>Créer un compte</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <span><?php echo $username_err; ?></span>
        </div>
        <div>
            <label>Mot de passe</label>
            <input type="password" name="password">
            <span><?php echo $password_err; ?></span>
        </div>
        <div>
            <label>Confirmer le mot de passe</label>
            <input type="password" name="confirm_password">
            <span><?php echo $confirm_password_err; ?></span>
        </div>
        <div>
            <input type="submit" value="S'inscrire">
        </div>
    </form>
</body>
</html>
