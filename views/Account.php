<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


// Affichage des erreurs
$errors = [];
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'invalid_password':
            $errors[] = "L'ancien mot de passe est incorrect.";
            break;
        case 'weak_password':
            $errors[] = "Le nouveau mot de passe n'est pas assez robuste.";
            break;
        case 'password_mismatch':
            $errors[] = "La confirmation du nouveau mot de passe ne correspond pas.";
            break;
        case 'update_error':
            $errors[] = "Une erreur s'est produite lors de la mise à jour du compte.";
            break;
        default:
            $errors[] = "Une erreur inconnue s'est produite.";
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer le compte</title>
    <link rel="stylesheet" href="../src/style/common.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <script src="../src/js/common.js"></script>
</head>
<body>
<div class="navbar">
    <button onclick="redirectTo('Account')">
        <span class="material-symbols-outlined">settings</span>
    </button>

    <button onclick="redirectTo('Friendship')">
        <span class="material-symbols-outlined">group</span>
    </button>

    <div class="userNav">

        <button onclick="redirectTo('Home')">

            <span class="material-symbols-outlined">home</span>

        </button>
        <h3><?= $_SESSION['username']?></h3>
        <div class="soldes">
            <span class="solde">Argent Fictif : <?= $_SESSION['soldeFictif']?></span>
        </div>
    </div>
    <button onclick="redirectTo('Games')">

        <span class="material-symbols-outlined">account_balance</span>

    </button>
    <button onclick="redirectTo('Logout')">

        <span class="material-symbols-outlined">logout</span>

    </button>
</div>

<div class="container">
    <div class="card">
    <h2>Gérer le compte</h2>
        <form action="../controller/accountController.php" method="post">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?= $_SESSION['nom']?>" required>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?= $_SESSION['prenom']?>" required>

            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" value="<?= $_SESSION['username']?>" required>

            <label for="password">Votre ancien mot de passe</label>
            <input type="password" id="old_password" name="old_password">

            <label for="new_password">Votre nouveau mot de passe</label>
            <input type="password" id="new_password" name="new_password">

            <label for="confirm_password">Confirmer votre nouveau mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password" >


            <input type="submit" class="submitButton" value="Mettre à jour">
        </form>
        </div>
    </div>
</body>
</html>
