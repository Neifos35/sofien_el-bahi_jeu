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
            <h1>S'inscrire à Kasyno !</h1>

            <form method="post">
                <input type="text" id="name" name="nom" placeholder="Votre nom"/>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom"/>
                <input type="text" id="username" name="username" placeholder="Votre nom d'utilisateur"/>
                <input type="email" id="email" name="email" placeholder="Votre email"/>
                <input type="password" id="password" name="password" placeholder="Choisir un mot de passe"/>
                <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmer le mot de passe"/>
                <input type="submit" class="submitButton" id="formSignin" name="formSignin" value="S'inscrire"/>
            </form>
           <?php include '../model/SigninController.php'; ?>
        </div>
    <div class="blur"></div>
</div>

</body>
</html>