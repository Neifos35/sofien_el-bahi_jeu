<?php
session_start();

if (isset($_POST["formSignin"])) {
    // Extraction et validation des entrées
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);

    // Inclure le modèle UserModel
    require_once "../model/UserModel.php";
    require_once "../model/Utils.php"; // Inclure le fichier Utils.php

    // Vérifier la robustesse du mot de passe
    $isStrongPassword = Utils::isStrongPassword($password);
    if ($isStrongPassword) {
        // Appel du modèle pour l'inscription de l'utilisateur
        $registered = UserModel::register($email, $username, $password, $nom, $prenom);

        if ($registered) {
            // Rediriger vers une autre page après l'inscription réussie si nécessaire
            header("Location: ../views/login.php");
            exit();
        } else {
            // Rediriger vers la page de création de compte avec un message d'erreur
            header("Location: ../views/Signin.php?error=user_exists");
            exit();
        }
    } else {
        // Rediriger vers la page de création de compte avec un message d'erreur
        header("Location: ../views/Signin.php?error=weak_password");
        exit();
    }
}
