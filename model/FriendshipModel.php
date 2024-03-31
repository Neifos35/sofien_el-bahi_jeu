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


    public static function addFriend($username1, $username2)
    {
        require_once "UserModel.php";
        require_once "../src/lib/Connexion.php";
        $connexion = Connexion::connect();

        // Récupérer l'ID du premier utilisateur
        $idusername1 = UserModel::getId($username1);
        // Récupérer l'ID du deuxième utilisateur
        $idusername2 = UserModel::getId($username2);

        // Vérifier si les deux utilisateurs existent
        if ($idusername1 && $idusername2) {
            // Check if friendship already exists to prevent duplicate entry
            $checkSql = "SELECT COUNT(*) FROM friendship WHERE (user_id1 = ? AND user_id2 = ?) OR (user_id1 = ? AND user_id2 = ?)";
            $checkStmt = $connexion->prepare($checkSql);
            $checkStmt->execute([$idusername1['id'], $idusername2['id'], $idusername2['id'], $idusername1['id']]);
            $exists = $checkStmt->fetchColumn() > 0;

            if ($exists) {
                // Friendship already exists
                return false;
            } else {
                // Friendship does not exist, proceed with insertion
                $sql = "INSERT INTO friendship (user_id1, user_id2, statut) VALUES (?, ?, ?)";
                $stmt = $connexion->prepare($sql);
                // Utiliser les valeurs d'identifiant de chaque utilisateur pour l'insertion
                return $stmt->execute([$idusername1['id'], $idusername2['id'], 0]);
            }
        } else {
            // Gérer le cas où l'un des utilisateurs n'existe pas
            return false;
        }
    }



    public static function getFriends($username)
    {
        require_once "UserModel.php";
        require_once "../src/lib/Connexion.php";
        $connexion = Connexion::connect();
        $user_id = UserModel::getId($username)['id'];

        $sql = "SELECT id, nom, prenom, username FROM user WHERE id IN (
                SELECT user_id2 FROM friendship WHERE user_id1 = ? AND statut = 1 
                UNION 
                SELECT user_id1 FROM friendship WHERE user_id2 = ? AND statut = 1
            )";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$user_id, $user_id]);
        $friends = $stmt->fetchAll();

        return $friends;
    }


    public static function acceptFriend($username1, $username2)
    {
        require_once "UserModel.php";
        require_once "../src/lib/Connexion.php";
        $connexion = Connexion::connect();

        // Récupérer l'ID du premier utilisateur
        $idusername1 = UserModel::getId($username1);
        // Récupérer l'ID du deuxième utilisateur
        $idusername2 = UserModel::getId($username2);


        $sql = "UPDATE friendship SET statut = 1 WHERE (user_id1 = ? AND user_id2 = ?) OR (user_id1 = ? AND user_id2 = ?)";
        $stmt = $connexion->prepare($sql);
        // Utiliser les valeurs d'identifiant de chaque utilisateur pour l'insertion
        return $stmt->execute([$idusername1['id'], $idusername2['id'],$idusername2['id'], $idusername1['id']]);

    }

    public static function rejectFriend($username1, $username2)
    {
        require_once "../src/lib/Connexion.php";
        require_once "UserModel.php";

        $connexion = Connexion::connect();

        // Récupérer l'ID du premier utilisateur
        $idusername1 = UserModel::getId($username1);
        // Récupérer l'ID du deuxième utilisateur
        $idusername2 = UserModel::getId($username2);

        // Vérifier si les deux utilisateurs existent
        if ($idusername1 && $idusername2) {
            $sql = "DELETE FROM friendship WHERE (user_id1 = ? AND user_id2 = ?) OR (user_id1 = ? AND user_id2 = ?)";
            $stmt = $connexion->prepare($sql);
            // Utiliser les valeurs d'identifiant de chaque utilisateur pour l'insertion
            return $stmt->execute([$idusername1['id'], $idusername2['id'], $idusername2['id'], $idusername1['id']]);
        } else {
            // Gérer le cas où l'un des utilisateurs n'existe pas
            return false;
        }
    }

    public static function getFriendRequests($username)
    {
        require_once "../src/lib/Connexion.php";
        $connexion = Connexion::connect();
        $sql = "SELECT id, nom, prenom, username FROM user WHERE id IN (SELECT user_id1 FROM friendship WHERE user_id2 = ? AND statut = 0)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetchAll();
    }



}
