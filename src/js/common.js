function redirectTo(nomRedirect) {
    if (nomRedirect === "Account") {
        window.location.href = 'Account.php';

    }else if(nomRedirect === "Home") {
        window.location.href = 'home.php';
    }else if(nomRedirect === "Friendship"){
        window.location.href = 'Friendship.php';
    }else if(nomRedirect === "Blackjack"){
        window.location.href = 'Blackjack.php';
    }else if(nomRedirect === "Texas"){
        window.location.href = 'Texas.php';
    }else if (nomRedirect === "Logout") {
        window.location.href = 'logout.php';
    }
}