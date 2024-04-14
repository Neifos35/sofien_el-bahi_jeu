<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../model/PokerModel.php";
require_once "../model/UserModel.php";

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour rejoindre une partie.']);
    exit;
}

// Utilisation de $_POST pour être cohérent avec la méthode de soumission du formulaire
if (!isset($_POST['game_id'])) {
    echo json_encode(['success' => false, 'message' => 'Aucun jeu spécifié.']);
    exit;
}

$gameId = $_POST['game_id'];
$username = $_SESSION['username'];

$joined = PokerModel::joinGame($gameId, $username);

if ($joined) {
    echo json_encode(['success' => true, 'message' => 'Vous avez rejoint la partie.', 'gameId' => $gameId]);

} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la tentative de rejoindre la partie.']);
}

