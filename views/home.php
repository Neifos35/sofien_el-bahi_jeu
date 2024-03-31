<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="../src/js/common.js"></script>
    <script src="../src/js/pokerTable.js"></script>
    <link rel="shortcut icon" href="../src/assets/Kasyno.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../src/style/common.css">
    <title>Kasyno</title>
</head>
<body>
<div class="navbar">
    <button onclick="redirectTo('Account')">
        <span class="material-symbols-outlined">settings</span>
    </button>
    <button onclick="redirectTo('Friendship')">
        <span class="material-symbols-outlined">group</span>
    </button>
    <div class="userNav">
        <button onclick="redirectTo('Home')">
            <span class="material-symbols-outlined">home</span>
        </button>
        <h3><?= $_SESSION['username'] ?></h3>
        <div class="solde">
            Argent Fictif : <?= $_SESSION['soldeFictif'] ?>
        </div>
    </div>
    <button onclick="redirectTo('Games')">
        <span class="material-symbols-outlined">account_balance</span>
    </button>
    <button onclick="redirectTo('Logout')">
        <span class="material-symbols-outlined">logout</span>
    </button>
</div>
<div class="jeux">
    <button id="blackjackButton" class="gameButton" onclick="redirectTo('Blackjack')">
        Blackjack
    </button>
    <button id="texasButton" class="gameButton" onclick="display('Texas')">
        Texas Hold'em
    </button>
</div>

<div id="Texas" class="overlay">
    <div class="popup">
        <button class="submitButton" onclick="closePopup('Texas')">Fermer</button>
        <div id="create-game-container">
            <button class="submitButton" id="createGameBtn">Créer une Nouvelle Table</button>
            <div id="gameInfo"></div>
        </div>

        <div id="join-game-container">
            <form onsubmit="joinGame(); return false;">
                <input type="text" id="gameIdInput" name="game_id" placeholder="ID de la Table" required>
                <button type="submit" class="submitButton">Rejoindre</button>
            </form>
            <div id="joinGameInfo"></div>
        </div>



    </div>
</div>

</body>
</html>
