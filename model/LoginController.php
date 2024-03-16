<?php


if (isset($_POST['formLogin'])) {
    // Extracting and sanitizing inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Check if required fields are not empty
    if (!empty($password) && !empty($email)) {
    // Include and establish database connection
        include '../src/lib/Connexion.php';
        $db = Connexion::connect();
        // Prepare and execute SQL query
        $q = $db->prepare("SELECT * FROM user WHERE mail = :mail");
        $q->execute(['mail' => $email]);
        $result = $q->fetch();

        // Check if user exists
        if ($result) {

            // Verify password
            if (password_verify($password, $result['password'])) {
                // Start session and store user information
                session_start();
                $_SESSION['username'] = $result['username'];
                $_SESSION['nom'] = $result['nom'];
                $_SESSION['prenom'] = $result['prenom'];
                $_SESSION['mail'] = $result['email'];
                $_SESSION['password'] = $result['password'];
                $_SESSION['soldeFictif'] = $result['soldeFictif'];

                // Redirect to index.php after successful login
                header("Location: index.php");
                exit();
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Le compte n'existe pas.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
