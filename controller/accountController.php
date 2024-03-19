<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Récupérer les données du formulaire
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
$prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$old_password = filter_input(INPUT_POST, 'old_password', FILTER_SANITIZE_STRING);
$new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
$confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);

// Inclure le modèle UserModel
require_once "../model/UserModel.php";

// Appel du modèle pour récupérer le hash du mot de passe actuel
$current_password_hash = UserModel::getPasswordHash($_SESSION['id']);

// Vérification si l'ancien mot de passe est correct
if (password_verify($old_password, $current_password_hash)) {
    // Inclure le modèle Utils
    require_once "../model/Utils.php";

    // Vérification de la robustesse du nouveau mot de passe
    $isStrongPassword = Utils::isStrongPassword($new_password);

    if ($isStrongPassword) {
        // Vérification si les nouveaux mots de passe correspondent
        if ($new_password === $confirm_password) {
            // Hashage du nouveau mot de passe
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            // Appel du modèle pour mettre à jour les informations du compte
            $update_result = UserModel::updateAccount($_SESSION['id'], $nom, $prenom, $username, $new_password_hash);

            if ($update_result) {
                // Mettre à jour les données de session
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['username'] = $username;

                // Rediriger vers la page de compte avec un message de succès
                header("Location: ../views/home.php");
                exit();
            } else {
                header("Location: ../views/Account.php?error=update_error");
                exit();
            }
        } else {
            header("Location: ../views/Account.php?error=password_mismatch");
            exit();
        }
    } else {
        header("Location: ../views/Account.php?error=weak_password");
        exit();
    }
} else {
    header("Location: ../views/Account.php?error=invalid_password");
    exit();
}
