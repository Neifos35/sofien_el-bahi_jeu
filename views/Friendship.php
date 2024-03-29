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

        <button onclick="redirectTo('Home')">

            <span class="material-symbols-outlined">home</span>

        </button>
        <h3><?= $_SESSION['username']?></h3>
        <div class="soldes">
            <span class="solde">Argent Fictif : <?= $_SESSION['soldeFictif']?></span>
        </div>
    </div>
    <button onclick="redirectTo('Games')">

        <span class="material-symbols-outlined">account_balance</span>

    </button>

    <button onclick="redirectTo('Logout')">

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
    <div class="card">
        <h2>Demandes d'amitié</h2>
        <?php
        require_once '../model/FriendshipModel.php';
        $requests = FriendshipModel::getFriendRequests($_SESSION['id']);
        if ($requests) {
            foreach ($requests as $request) {
                $_SESSION['friendUsername'] = $request['username'];
                echo '<div class="alignFriendship">' . $request['username'] .  '<form class="alignFriendship" method="post" action="../controller/FriendshipController.php">
                <input type="hidden" name="username" value="' . $request['username'] . '"> 
                <input type="submit" class="rejectButton" name="rejectButton" value="Supprimer"> 
                <input type="submit" class="acceptButton" name="acceptButton" value="Accepter">
                </form>   
                
                
                </div>';


            }
        }
        ?>
    </div>
</div>
<div class="container">
    <div class="card">
        <h2>Amis</h2>
        <?php
        require_once '../model/FriendshipModel.php';

        $friends = FriendshipModel::getFriends($_SESSION['username']);
        if ($friends) {
            foreach ($friends as $friend) {
                $_SESSION['friendUsername'] = $friend['username'];
                echo '<div class="alignFriendship">' . $friend['username'] . '<form class="alignFriendship" method="post" action="../controller/FriendshipController.php">
                <input type="submit" class="rejectButton" name="rejectButton" value="Supprimer"> 
               
                </form> </div>';
            }
        }
        ?>



</div>

</body>
</html>
