<?php
class UserModel {
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

    public static function login($email, $password) {
        // Inclure la configuration de connexion à la base de données
        require_once "../src/lib/Connexion.php";

        // Établir une connexion à la base de données
        $db = Connexion::connect();

        // Préparer et exécuter la requête SQL pour récupérer les informations de l'utilisateur
        $query = $db->prepare("SELECT * FROM user WHERE mail = :mail");
        $query->execute(['mail' => $email]);
        $user = $query->fetch();

        // Vérifier si l'utilisateur existe dans la base de données
        if ($user) {
            // Vérifier si le mot de passe correspond
            if (password_verify($password, $user['password'])) {
                return $user; // Retourner les informations de l'utilisateur
            }
        }

        return false; // Retourner false si l'utilisateur n'est pas trouvé ou si le mot de passe est incorrect
    }
    public static function register($email, $username, $password, $nom, $prenom) {
        // Inclure la configuration de connexion à la base de données
        require_once "../src/lib/Connexion.php";

        // Établir une connexion à la base de données
        $db = Connexion::connect();

        // Préparer et exécuter la requête SQL pour vérifier si l'email ou le nom d'utilisateur existe déjà
        $queryEmail = $db->prepare("SELECT mail FROM user WHERE mail = :mail");
        $queryEmail->execute(['mail' => $email]);
        $resultEmail = $queryEmail->fetchColumn();

        $queryUsername = $db->prepare("SELECT username FROM user WHERE username = :username");
        $queryUsername->execute(['username' => $username]);
        $resultUsername = $queryUsername->fetchColumn();

        // Vérifier si l'email ou le nom d'utilisateur existe déjà
        if (!$resultEmail && !$resultUsername) {
            // Hasher le mot de passe
            $hashpass = password_hash($password, PASSWORD_BCRYPT);

            // Préparer et exécuter la requête SQL pour insérer le nouvel utilisateur dans la base de données
            $queryInsert = $db->prepare("INSERT INTO user(mail,password,nom,prenom,username) VALUES(:mail,:password,:nom,:prenom,:username)");
            $queryInsert->execute([
                'mail' => $email,
                'password' => $hashpass,
                'nom' => $nom,
                'prenom' => $prenom,
                'username' => $username,
            ]);
            return true; // Retourner true en cas de succès
        } else {
            return false; // Retourner false si l'email ou le nom d'utilisateur existe déjà
        }
    }
    public static function updateAccount($id, $nom, $prenom, $username, $password) {
        // Inclure la configuration de connexion à la base de données
        require_once "../src/lib/Connexion.php";

        // Connexion à la base de données
        $connexion = Connexion::connect();
        if ($connexion === null) {
            return false; // Gérer l'erreur de connexion
        }

        // Mettre à jour les informations du compte dans la base de données
        $sql = "UPDATE user SET nom=?, prenom=?, username=?, password=? WHERE id=?";
        $stmt = $connexion->prepare($sql);
        return $stmt->execute([$nom, $prenom, $username, $password, $id]);
    }
}
