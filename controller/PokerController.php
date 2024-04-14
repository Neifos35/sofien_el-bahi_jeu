<?php

header('Content-Type: application/json');
session_start();

require_once "../model/PokerModel.php";
require_once "../model/UserModel.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['username'])) {
        echo json_encode(['success' => false, 'message' => 'Authentication required.']);
        exit;
    }

    $creatorUsername = $_SESSION['username'];
    try {
        $userId = UserModel::getId($creatorUsername);

        if (!$userId) {
            throw new Exception("User ID retrieval failed.");
        }

        $gameId = PokerModel::createGame($userId['id']);
        if ($gameId) {
            echo json_encode(['success' => true, 'gameId' => $gameId]);
        } else {
            throw new Exception("Failed to create game.");
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Server error occurred.', 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
