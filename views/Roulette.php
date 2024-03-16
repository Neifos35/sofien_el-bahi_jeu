<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="../src/js/roulette.js"></script>
    <link rel="stylesheet" href="../src/style/roulette.css">
    <title>Kasyno</title>
</head>
<body>
<?php
session_start();


?>
<div class="container">
    <div class="roulette-wheel">
        <div class="number" id="number">0</div>
        <div class="color" id="color">Red</div>
        <button onclick="spin()">Spin</button>
    </div>
    <div class="bet">
        <input type="number" id="betAmount" placeholder="Bet amount">
        <input type="number" id="betNumber" placeholder="Bet number (0-36)">
        <select id="betColor">
            <option value="Red">Red</option>
            <option value="Black">Black</option>
        </select>
        <button onclick="placeBet()">Place Bet</button>
    </div>
</div>



</body>
</html>
