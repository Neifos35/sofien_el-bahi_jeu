<?php
class Utils {
    public static function isStrongPassword($password) {
        // Vérification de la longueur minimale
        if (strlen($password) < 12) {
            return false;
        }

        // Vérification de la présence d'au moins une majuscule, une minuscule, un chiffre et un caractère spécial
        if (!preg_match('/[A-Z]/', $password) || // Vérifie la présence d'au moins une majuscule
            !preg_match('/[a-z]/', $password) || // Vérifie la présence d'au moins une minuscule
            !preg_match('/[0-9]/', $password) || // Vérifie la présence d'au moins un chiffre
            !preg_match('/[^a-zA-Z0-9]/', $password)) { // Vérifie la présence d'au moins un caractère spécial
            return false;
        }

        return true;
    }

    public static function getPasswordHash($id) {
        // Inclure la configuration de connexion à la base de données
        require_once "../src/lib/Connexion.php";

        // Connexion à la base de données
        $connexion = Connexion::connect();
        if ($connexion === null) {
            return false; // Gérer l'erreur de connexion
        }

        // Récupérer le hash du mot de passe actuel de l'utilisateur
        $sql = "SELECT password FROM user WHERE id = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$id]);
        $password_hash = $stmt->fetchColumn();

        return $password_hash;
    }

}