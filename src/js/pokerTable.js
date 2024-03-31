/************* Création table Texas hold'em *******************/
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createGameBtn').addEventListener('click', function() {
        let formData = new FormData();
        formData.append('action', 'create');

        fetch('../controller/PokerController.php', { // Ajustez cette URL à votre endpoint correct
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

                } else {
                    // Gérer les erreurs ici, si nécessaire
                    console.log(data.message); // Affichage de l'erreur dans la console à titre d'exemple
                }
            })
            .catch(error => console.error('Erreur:', error));
    });
});

function joinGame(gameId) {
    let formData = new FormData();
    formData.append('action', 'join');
    formData.append('game_id', gameId);

    fetch('../controller/PokerController.php', { // Ajustez cette URL à votre endpoint correct
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
                // Si le joueur a rejoint la partie avec succès, redirigez vers la page de la partie
                window.location.href = 'Texas.php?game_id=' + gameId;
            } else {
                // Gérer les erreurs ici, si nécessaire
                console.log(data.message); // Affichage de l'erreur dans la console à titre d'exemple
            }
        })
        .catch(error => console.error('Erreur:', error));
}