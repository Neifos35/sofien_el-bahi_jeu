<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="../src/js/roulette.js"></script>
    <link rel="shortcut icon" href="../src/assets/Kasyno.jpg" type="image/x-icon">
    <link rel=stylesheet href="../src/style/common.css">
    <title>Kasyno</title>
</head>
<body>
<?php
session_start();
if (isset($_SESSION['error'])) {
echo '<div class="error">' . $_SESSION['error'] . '</div>';
unset($_SESSION['error']); // Efface le message d'erreur après l'avoir affiché
}
?>
<div class="containerSignin">

        <div class="cardSignin">
            <img src="../src/assets/Kasyno.jpg" class="logo" alt="logo casino">
            <h1>S'inscrire à Kasyno !</h1>

            <form action="../controller/SigninController.php" method="post">
                <div class="alignLabel">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="alignLabel">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                <div class="alignLabel">
                    <label for="username">Pseudo :</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="alignLabel">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <span>Au moins : 12 caractères, 1 majuscule, 1 minuscule, 1 caractère spéciale</span>
                <div class="alignLabel">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>

                </div>
                <div class="alignLabel">
                    <label for="passwordConfirm">Confirmer le mot de passe :</label>
                    <input type="password" id="passwordConfirm" name="passwordConfirm" required>
                </div>


                <input type="submit" class="submitButton" name="formSignin" value="S'inscrire">
            </form>
            <p>Déjà un compte ? </p>
            <a href="Login.php">Se connecter</a>
        </div>

</div>

</body>
</html>