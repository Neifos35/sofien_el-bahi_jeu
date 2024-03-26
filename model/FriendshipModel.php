<?php

class FriendshipModel
{
    public static function searchUser($username)
    {
        require_once "../src/lib/Connexion.php";
        $connexion = Connexion::connect();
        $searchTerm = "%$username%"; // Ajoutez des caractères de joker pour la correspondance partielle
        $sql = "SELECT id, nom, prenom, username FROM user WHERE username LIKE ? OR nom LIKE ? OR prenom LIKE ?";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    public static function getId($username)
        {
            require_once "../src/lib/Connexion.php";
            $connexion = Connexion::connect();
            $sql = "SELECT id FROM user WHERE username = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetch();
        }

    public static function addFriend($username1, $username2)
    {
        require_once "../src/lib/Connexion.php";
        $connexion = Connexion::connect();

        // Récupérer l'ID du premier utilisateur
        $idusername1 = self::getId($username1);
        // Récupérer l'ID du deuxième utilisateur
        $idusername2 = self::getId($username2);

        // Vérifier si les deux utilisateurs existent
        if ($idusername1 && $idusername2) {
            $sql = "INSERT INTO friendship (user_id1, user_id2) VALUES (?, ?)";
            $stmt = $connexion->prepare($sql);
            // Utiliser les valeurs d'identifiant de chaque utilisateur pour l'insertion
            return $stmt->execute([$idusername1['id'], $idusername2['id']]);
        } else {
            // Gérer le cas où l'un des utilisateurs n'existe pas
            return false;
        }
    }


    public static function getFriends($username)
    {
        require_once "../src/lib/Connexion.php";
        $connexion = Connexion::connect();
        $sql = "SELECT id, nom, prenom, username FROM user WHERE id IN (SELECT user_id2 FROM friendship WHERE user_id1 = ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetchAll();
    }
}
