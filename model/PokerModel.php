<?php

// PokerGameModel.php
require_once "../src/lib/Connexion.php";
class PokerModel
{
    public static function createGame($player1_id, $player2_id = null)
    {
        $connexion = Connexion::connect();

        $sql = "INSERT INTO games (player1_id, player2_id, state, active, winner_id, created_at, updated_at) 
            VALUES (?, NULL, ?, ?, NULL, NOW(), NOW())";

        $stmt = $connexion->prepare($sql);
        $state = 'waiting';
        $active = 1;

        // Exécution de la requête
        $success = $stmt->execute([$player1_id, $state, $active]);



        if ($success) {
            // Retourne l'identifiant du jeu si la création est réussie
            return $connexion->lastInsertId();
        } else {
            // En cas d'échec, retourne false
            return false;
        }
    }

    public static function checkGameStatus($gameId)
    {
        $connexion = Connexion::connect();

        $sql = "SELECT state, player2_id FROM games WHERE id = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$gameId]);

        $gameStatus = $stmt->fetch();

        return $gameStatus;
    }

    public static function joinGame($gameId, $player2Username) {
        $connexion = Connexion::connect();


        $player2Id = UserModel::getId($player2Username);

        if (!$player2Id) {
            return false; // L'utilisateur n'existe pas
        }

        $sql = "UPDATE games SET player2_id = ?, state = 'started' WHERE id = ? AND player2_id IS NULL";
        $stmt = $connexion->prepare($sql);
        $success = $stmt->execute([$player2Id, $gameId]);

        return $success;
    }


}
