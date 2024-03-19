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
<div class="container">

    <div class="card">
        <img src="../src/assets/Kasyno.jpg" class="logo" alt="logo casino">
        <h1>Se connecter à Kasyno !</h1>
        <form action="../controller/LoginController.php" method="post">
            <div class="alignLabel">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="alignLabel">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <input type="submit" class="submitButton"name="formLogin" value="Se connecter">
        </form>
      <p>Pas encore de compte ? </p>
        <a href="Signin.php">S'inscrire</a>
    </div>



</div>

</body>
</html>