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
function fetchAndHandle(url, formData) {
    fetch(url, {
        method: 'POST',
        body: formData,
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not OK: ' + response.statusText);
            }
            return response.text(); // first read it as text
        })
        .then(text => {
            try {
                const data = JSON.parse(text); // try to parse it as json
                return data;
            } catch (error) {
                throw new Error('Failed to parse JSON: ' + text); // throw if json parsing fails
            }
        })
        .then(data => {
            if (data.success) {
                window.location.href = `Texas.php?game_id=${data.gameId}`;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error during operation: " + error.message);
        });
}

document.getElementById('createGameBtn').addEventListener('click', function() {
    let formData = new FormData();
    formData.append('action', 'create');
    fetchAndHandle('../controller/PokerController.php', formData);
});

function joinGame() {
    const gameId = document.getElementById('gameIdInput').value;
    if (!gameId) {
        alert("Veuillez entrer un ID de table.");
        return;
    }
    let formData = new FormData();
    formData.append('game_id', gameId);
    fetchAndHandle('../controller/JoinGameController.php', formData);
    return false; // prevent default form submission if used in form
}
