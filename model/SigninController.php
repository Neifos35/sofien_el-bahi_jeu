<?php
if (isset($_POST["formSignin"])) {
    // Extracting and sanitizing inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);

    // Check if required fields are not empty
    if (!empty($password) && !empty($passwordConfirm) && !empty($email)) {

        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            // Check if passwords match
            if ($password === $passwordConfirm) {

                // Hash the password
                $hashpass = password_hash($password, PASSWORD_BCRYPT);

                // Include and establish database connection
                include '../src/lib/Connexion.php';
                $db = Connexion::connect();

                // Prepare and execute SQL queries
                $c = $db->prepare("SELECT mail FROM user WHERE mail = :mail");
                $c->execute(['mail' => $email]);
                $resultEmail = $c->fetchColumn();

                $c1 = $db->prepare("SELECT username FROM user WHERE username = :username");
                $c1->execute(['username' => $username]);
                $resultUsername = $c1->fetchColumn();

                // Check if email or username already exists
                if (!$resultEmail && !$resultUsername) {
                    $q = $db->prepare("INSERT INTO user(mail,password,nom,prenom,username) VALUES(:mail,:password,:nom,:prenom,:username)");
                    $q->execute([
                        'mail' => $email,
                        'password' => $hashpass,
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'username' => $username,
                    ]);
                    echo "User registered successfully.";
                } else {
                    echo "An user already exists with this email or username.";
                }
            } else {
                echo "Passwords do not match.";
            }
        } else {
            echo "Invalid email format.";
        }
    } else {
        echo "Please fill all required fields.";
    }
}
?>
