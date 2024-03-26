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
<html lang="fr">
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
<div class="container">
    <div class="card">
        <h2>Rechercher un utilisateur</h2>

        <form action="../controller/FriendshipController.php" method="post">
            <div class="alignLabel">
                <label for="nom">Nom d'utilisateur :</label>
                <input type="text" name="username" required>
            </div>

            <input type="submit" class="submitButton" name="searchButton" value="Rechercher">
        </form>
    </div>
</div>

<div class="container">
    <div class="card">
        <h2>Résultat de la recherche</h2>

        <form action="../controller/FriendshipController.php" method="post">
        <div>
            <label for="nom">Nom d'utilisateur :</label>
            <span><?= isset($_SESSION['searchedUsername']) ? $_SESSION['searchedUsername'] : '' ?></span>
        </div>
        <div>
            <label for="nom">Nom :</label>
            <span><?= isset($_SESSION['searchedUserNom']) ? $_SESSION['searchedUserNom'] : '' ?></span>
        </div>
           <div>
            <label for="nom">Prénom :</label>
            <span><?= isset($_SESSION['searchedUserPrenom']) ? $_SESSION['searchedUserPrenom'] : '' ?></span>
           </div>



            <input type="submit" class="submitButton" name="addButton" value="Ajouter">
        </form>
    </div>
</div>
<div class="container">
    <div class="card">
        <h2>Amis</h2>
        <ul><?php
            if (isset($_SESSION['friends'])) {
                foreach ($_SESSION['friends'] as $friend) {
                    echo '<li>' . $friend['username'] . '</li>';
                }
            }
            ?>

        </ul>

</div>

</body>
</html>
