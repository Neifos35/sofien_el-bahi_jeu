function getGameIdFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('game_id');
}



function checkGameStatus() {
    const gameId = getGameIdFromURL();
    fetch(`../controller/CheckGameStatusController.php?game_id=${gameId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.gameStarted) {
                document.getElementById('status').textContent = "Le jeu commence !";
                document.getElementById('actionButtons').style.display = 'flex';
                clearInterval(checkInterval); // Arrêtez la vérification périodique
            } else {
                document.getElementById('status').textContent = "En attente d'un autre joueur...";
                document.getElementById('actionButtons').style.display = 'none';
            }
        })

        .catch(error => console.error('Erreur:', error));
}


// Commencez à vérifier l'état du jeu toutes les 5 secondes
const checkInterval = setInterval(checkGameStatus, 5000);
