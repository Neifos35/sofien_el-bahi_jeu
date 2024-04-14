<?php

session_start();

if (!isset($_GET['game_id'])) {
    die('Aucun jeu spécifié.');
}

$gameId = $_GET['game_id'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="../src/js/texas.js"></script>
    <link rel="stylesheet" href="../src/style/texas.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Angkor&display=swap" rel="stylesheet">
    <title>Kasyno</title>
</head>
<body>
<div class="TableExt">
    <div class="TableInt">
        <div class="TableDecoration">
            <span id="dealer-score-value"></span>
            <div id="opponent-hand">
                <div class="card BackgroundRed"></div>
                <div class="card BackgroundRed"></div>
                <div id="opponent-name">Nom de l'Adversaire</div>
            </div>
            <div id="community-cards"></div>
            <div id="player-hand">
                <div id="cards"></div>
            </div>
            <span id="player-score-value"></span>

            <div id="pot"></div>
        </div>
    </div>
</div>

<div class="btnAction" id="actionButtons">
    <button id="check" onclick="playerAction('check')">Check</button>
    <button id="fold" onclick="playerAction('fold')">Fold</button>
    <input type="range" id="raise-amount" min="1" max="100">
    <button onclick="playerAction('raise')">Raise</button>
</div>
</body>
</html>
