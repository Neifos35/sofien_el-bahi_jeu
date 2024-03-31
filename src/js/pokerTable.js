/************* Création table Texas hold'em *******************/
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createGameBtn').addEventListener('click', function() {
        let formData = new FormData();
        formData.append('action', 'create');

        fetch('../controller/PokerController.php', {
            method: 'POST',
            credentials: 'same-origin',
            body: formData,
        })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new TypeError("Oops, nous n'avons pas du JSON!");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Si la partie a été créée avec succès, redirigez vers la page de la partie
                    window.location.href = 'Texas.php?game_id=' + data.gameId;

                }
            })
            .catch(error => console.error('Erreur:', error));
    });
});

/************* Rejoindre table Texas hold'em *******************/

function joinGame() {
    const gameId = document.getElementById('gameIdInput').value;
    if (!gameId) {
        alert("Veuillez entrer un ID de table.");
        return;
    }

    let formData = new FormData();
    formData.append('game_id', gameId);

    fetch('../controller/JoinGameController.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Afficher les données JSON converties
            if (data.success) {
                console.log(data.gameId); // Vérifier la valeur de 'gameId'
                window.location.href = `Texas.php?game_id=${data.gameId}`;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert("Erreur lors de la tentative de rejoindre la table.");
        });


}
