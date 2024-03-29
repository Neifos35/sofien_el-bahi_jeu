<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


// Affichage des erreurs
$errors = [];
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'invalid_password':
            $errors[] = "L'ancien mot de passe est incorrect.";
            break;
        case 'weak_password':
            $errors[] = "Le nouveau mot de passe n'est pas assez robuste.";
            break;
        case 'password_mismatch':
            $errors[] = "La confirmation du nouveau mot de passe ne correspond pas.";
            break;
        case 'update_error':
            $errors[] = "Une erreur s'est produite lors de la mise à jour du compte.";
            break;
        default:
            $errors[] = "Une erreur inconnue s'est produite.";
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer le compte</title>
    <link rel="stylesheet" href="../src/style/common.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <script src="../src/js/common.js"></script>
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
        <button class="submitButton" onclick="display('Blackjack')">Blackjack</button>

        <button class="submitButton" onclick="display('Texas')">Texas Hold'em</button>

        <button class="submitButton" onclick="display('Roulette')">Roulette</button>

        <div id="Blackjack">
            <button class="submitButton" onclick="closePopup('Blackjack')">Fermer</button>
            <h2>Blackjack</h2>
            <h3>Règles du jeu</h3>
            <div>
                <p>Le but du jeu est de battre le croupier en obtenant une main dont la valeur est la plus proche possible de 21 sans la dépasser.</p><br>
                <p>Chaque carte a une valeur numérique : les cartes numérotées valent leur valeur, les figures (roi, dame, valet) valent 10 points et l'as vaut 1 ou 11 points.</p><br>
                <p>Si le joueur dépasse 21 points, il perd la partie. Si le joueur obtient 21 points avec ses deux premières cartes (un as et une carte valant 10 points), il obtient un blackjack et remporte la partie.</p> <br>
                <p>Le croupier doit tirer des cartes supplémentaires jusqu'à ce qu'il atteigne un total de 17 points ou plus. Si le croupier dépasse 21 points, le joueur remporte la partie.</p> <br>
                <p>Le joueur gagne si sa main est plus proche de 21 points que celle du croupier sans dépasser 21 points.</p>
            </div>
        </div>

        <div id="Texas">
            <button class="submitButton" onclick="closePopup('Texas')">Fermer</button>
            <h2>Texas Hold'em</h2>

            <div>
                <h3>Règles du jeu</h3>
                <p>Le Texas Hold'em est une variante du poker. Chaque joueur reçoit deux cartes fermées et cinq cartes communes sont distribuées au centre de la table.</p><br>
                <p>Les joueurs doivent former la meilleure combinaison de cinq cartes possible en utilisant leurs deux cartes fermées et les cinq cartes communes.</p><br>
                <p>Les combinaisons de cartes possibles sont les suivantes, du plus faible au plus fort :<br>
                    - Carte haute : la main la plus faible, sans combinaison<br>
                    - Paire : deux cartes de même valeur<br>
                    - Double paire : deux paires de cartes de même valeur<br>
                    - Brelan : trois cartes de même valeur<br>
                    - Suite : cinq cartes consécutives<br>
                    - Couleur : cinq cartes de la même couleur<br>
                    - Full : un brelan et une paire<br>
                    - Carré : quatre cartes de même valeur<br>
                    - Quinte flush : une suite de cinq cartes de la même couleur<br>
                    - Quinte flush royale : une suite de 10 à l'as de la même couleur</p>
            </div>


        </div>

        <div id="Roulette">
            <button class="submitButton" onclick="closePopup('Roulette')">Fermer</button>
            <h2>Roulette</h2>
            <h3>Règles du jeu</h3>
            <div>
                <p>La roulette est un jeu de hasard dans lequel le joueur mise sur un numéro, une couleur ou une combinaison de numéros.</p><br>
                <p>Le croupier lance une bille dans un cylindre en rotation et les joueurs doivent deviner où la bille s'arrêtera.</p><br>
                <p>Les mises peuvent être placées sur un numéro spécifique, une couleur (rouge ou noir), un groupe de numéros, un numéro pair ou impair, ou un numéro bas (1-18) ou haut (19-36).</p><br>
                <p>Si la bille s'arrête sur le numéro ou la couleur sur lequel le joueur a misé, il remporte la partie.</p>
            </div>

    </div>
</div>
</body>
</html>
