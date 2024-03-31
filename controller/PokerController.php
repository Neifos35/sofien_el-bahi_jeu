<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json'); // S'assurer que le type de contenu est défini

    session_start();
    require_once "../model/PokerModel.php";
    require_once "../model/UserModel.php";

    if (isset($_SESSION['username'])) {
        $creatorUsername = $_SESSION['username'];

        try {
            $gameId = UserModel::getId($creatorUsername);
            $gameId = PokerModel::createGame($gameId['id']);

            if ($gameId) {
                echo json_encode(['success' => true, 'gameId' => $gameId]);
            } else {
                // Vous pourriez vouloir fournir plus de détails sur l'échec ici
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la création de la partie.']);
            }
        }
        catch (Exception $e) {
                error_log($e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Erreur serveur.', 'error' => $e->getMessage()]);
            }


    } else {
        echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour créer une partie.']);
    }
}
