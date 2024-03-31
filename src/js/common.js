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
        window.location.href = '../model/logout.php';
    }else if (nomRedirect === "Roulette") {
        window.location.href = 'Roulette.php';
    }
    else if (nomRedirect === "Games") {
        window.location.href = 'Games.php';
    }
}
function acceptFriend(username1, username2) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../controller/FriendshipController.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status === 200) {
            // Gérer la réponse du serveur
            console.log(this.responseText);
            // Optionally, you can reload the page or update UI here
            location.reload(); // Reloads the page after successful acceptance
        } else {
            // Gérer l'erreur
            console.log('Erreur de requête : ' + this.status);
        }
    };

    var data = 'acceptButton=true&username1=' + encodeURIComponent(username1) + '&username2=' + encodeURIComponent(username2);
    xhr.send(data);

}

/*************** Popup functions ***************/
function display(elementId) {
    var element = document.getElementById(elementId);
    element.style.display = 'flex';
    document.getElementById('overlay' + elementId).style.display = 'flex';
}

function closePopup(elementID) {
    document.getElementById(elementID).style.display = 'none';
    document.getElementById('overlay' + elementID).style.display = 'none';
}
