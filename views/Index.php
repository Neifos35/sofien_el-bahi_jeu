<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="../src/js/roulette.js"></script>
    <script src="../src/js/logout.js"></script>
    <link rel="shortcut icon" href="../src/assets/Kasyno.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../src/style/common.css">
    <title>Kasyno</title>
</head>
<body>
    <?php

    session_start();

    // Check si une session n'est pas encore active
    if (!isset($_SESSION['username'])) {
        echo '<div class="container">
              <div class="card">
            <img src="../src/assets/Kasyno.jpg" class="logo" alt="logo casino">
            <h1>Welcome to fabulous Kasyno !</h1>
            <form action="Login.php" method="post">
                <input class="submitButton" type="submit" value="Login"/>
            </form>
            <form action="Signin.php" method="post">
                <input class="submitButton" type="submit" value="Signin"/>
            </form>
        </div>
        </div>';
    }else {
        echo '<div class="navbar">
              <button><span class="material-symbols-outlined">manage_accounts</span></button> 
              <div class="userNav">
                    <h3>' . $_SESSION['username'] . '</h3>
                    <div class="soldes">                     
                        <span class="solde">Argent Fictif : ' . $_SESSION['soldeFictif'] . '</span>
                    </div>
              </div> 
              
              <button onclick="logout()">Se déconnecter</button>
          </div>
          <div class="jeux">
            
              <form  action="Blackjack.php" method="post">
                    <input id="blackjack" type="submit" value="Blackjack"/>
                    <span id="blackjackHide">Blackjack</span>
                </form>
              
              <form  action="Roulette.php" method="post">
                    <input id="roulette" type="submit" value="Roulette"/>
                    <span id="rouletteHide">Roulette</span>
                </form>
              
          </div>
       
          
          ';
    }
    ?>


</body>
</html>
