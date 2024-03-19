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
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error === "user_exists") {
        echo "<p>Un utilisateur existe déjà avec cet email ou ce nom d'utilisateur.</p>";
    } elseif ($error === "weak_password") {
        echo "<p>Le mot de passe n'est pas assez robuste. Il doit faire au moins 12 caractères et contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.</p>";
    }
}
?>
<div class="container">

        <div class="card">
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