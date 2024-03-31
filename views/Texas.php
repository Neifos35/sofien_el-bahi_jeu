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
    <script src="../src/js/checkGameStatus.js"></script>
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

            <span id="status">Vérification de l'état du jeu...</span>
            <div id="dealer-hand">
                <div id="cards">

                </div>
            </div>
            <div id="player-hand">
                <div id="cards">

                </div>
            </div>
            <span id="player-score-value"></span>
        </div>
    </div>
</div>
<div class="btnAction" id="actionButtons">
    <button id="hit-btn">Tirer une carte</button>
    <button id="stand-btn">Rester</button>
</div>


</body>
</html>
