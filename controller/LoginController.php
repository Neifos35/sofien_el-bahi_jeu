<?php
session_start();

if (isset($_POST['formLogin'])) {
    // Récupérer les données du formulaire
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Inclure le modèle UserModel
    require_once "../model/UserModel.php";

    // Appel du modèle pour vérifier les informations de connexion
    $user = UserModel::login($email, $password);

    if ($user) {
        // Démarre la session et stocke les informations de l'utilisateur
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['mail'] = $user['email'];
        $_SESSION['password'] = $user['password'];
        $_SESSION['soldeFictif'] = $user['soldeFictif'];

        // Redirige vers la page d'accueil après la connexion réussie
        header("Location: ../views/home.php");
        exit();
    } else {
        echo "Mot de passe incorrect ou compte inexistant.";
    }
}
