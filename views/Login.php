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
    <div class="blur"></div>
        <div class="card">
            <img src="../src/assets/Kasyno.jpg" class="logo" alt="logo casino">
            <h1>Se connecter à Kasyno !</h1>

            <form method="post">
                <input type="email" name="email" placeholder="Votre email"/>
                <input type="password" name="password" placeholder="Votre mot de passe"/>
                <input class="submitButton" type="submit" name="formLogin" value="Se connecter"/>
            </form>
          <p>Mot de passe oublié? Cliquez</p>
            <a>ici</a>
        </div>
    <?php include "../model/LoginController.php"; ?>
    <div class="blur"></div>
    
    
</div>

</body>
</html>