<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="../src/js/blackjack.js"></script>
    <link rel="stylesheet" href="../src/style/blackjack.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Angkor&display=swap" rel="stylesheet">

    <title>Kasyno</title>
</head>
<body>
<?php
session_start();

?>
<h1>Blackjack</h1>
<div class="TableExt">
    <div class="TableInt">
        <div class="TableDecoration">
            <span id="dealer-score-value"></span>


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
<div class="btnAction">
    <span id="status"></span>
    <button id="hit-btn"> Tirer une carte</button>
    <button id="stand-btn">Rester</button>
    <button id="reset-btn">Nouvelle partie</button>
</div>


</body>
</html>
