<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <script src="../src/js/common.js"></script>
    <script src="../src/js/logout.js"></script>
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
        <h3><?= $_SESSION['username']?></h3>
        <div class="soldes">
            <span class="solde">Argent Fictif : <?= $_SESSION['soldeFictif']?></span>
        </div>
    </div>
    <button onclick="redirectTo('Account')">

        <span class="material-symbols-outlined">account_balance</span>

    </button>
    <button onclick="redirectTo('Account')">

        <span class="material-symbols-outlined">logout</span>

    </button>
</div>
<div class="jeux">
  <button id="blackjack" onclick="redirectTo('Blackjack')">
        <span id="blackjackHide">Blackjack</span>
    </button>
  <button id="Texas" onclick="redirectTo('Texas')"><span id="TexasHide">Texas Hold'em</span>

  </button>
</div>



</body>
</html>
