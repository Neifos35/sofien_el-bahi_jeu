<?php

session_start();

if (isset($_POST['searchButton'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);

    require_once "../model/FriendshipModel.php";

    $searchResult = FriendshipModel::searchUser($username);

    if ($searchResult) {

        // Récupérer le premier utilisateur trouvé
        $user = $searchResult[0];

        $_SESSION['searchedUsername'] = $user['username'];
        $_SESSION['searchedUserNom'] = $user['nom'];
        $_SESSION['searchedUserPrenom'] = $user['prenom'];

        header("Location: ../views/Friendship.php");
        exit();
    } else {
        $_SESSION['error'] = 'Utilisateur introuvable';
        exit();
    }
}
if(isset($_POST['addButton'])) {
    $username1 = $_SESSION['username'];
    $username2 = $_SESSION['searchedUsername'];

    require_once "../model/FriendshipModel.php";

    $result = FriendshipModel::addFriend($username1, $username2);

    if ($result) {
        $_SESSION['success'] = 'Demande d\'amitié envoyée';
        header("Location: ../views/Friendship.php");
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'envoi de la demande d\'amitié';
        header("Location: ../views/Friendship.php");
        exit();
    }
}
