<?php

session_start();
require_once "../model/PokerModel.php";

header('Content-Type: application/json');

if (!isset($_GET['game_id'])) {
    echo json_encode(['success' => false, 'message' => 'Aucun jeu spécifié.']);
    exit;
}

$gameId = $_GET['game_id'];
$gameStatus = PokerModel::checkGameStatus($gameId);


if ($gameStatus && $gameStatus['state'] == 'started' && $gameStatus['player2_id'] != null) {
    echo json_encode(['success' => true, 'gameStarted' => true]);
} else {
    echo json_encode(['success' => true, 'gameStarted' => false]);
}
