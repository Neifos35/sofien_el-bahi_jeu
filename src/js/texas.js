
// Récupère l'ID du jeu à partir de l'URL
const gameId = new URLSearchParams(window.location.search).get('game_id');

// Initialise une connexion WebSocket
let conn = new WebSocket('ws://localhost:8080');

// Variable pour stocker l'ID du joueur actuel
let myPlayerId;

// Établit la connexion WebSocket
conn.onopen = () => {
    console.log('Connexion WebSocket ouverte.');
    // Envoie l'ID du jeu au serveur WebSocket pour rejoindre le jeu
    conn.send(JSON.stringify({ action: 'joinGame', gameId: gameId }));
};

conn.onmessage = (event) => {
    const message = JSON.parse(event.data);

    switch (message.action) {
        case 'deal':
            displayPlayerCards(message.hand);
            break;

        case 'gameState':
            updateUI(message.state);
            break;

    }
};

// Gère les erreurs WebSocket
conn.onerror = (error) => {
    console.error('Erreur WebSocket:', error);
};

// Fonction pour envoyer des actions de joueur au serveur
function sendAction(action, amount = 0) {
    if (conn.readyState === WebSocket.OPEN) {
        conn.send(JSON.stringify({ action: action, gameId: gameId, amount: amount, playerId: myPlayerId }));
    } else {
        console.error('La connexion WebSocket n\'est pas ouverte.');
    }
}

// Met à jour l'interface utilisateur en fonction de l'état du jeu
function updateUI(state) {
    // Exemple de mise à jour de l'interface : le pot actuel
    document.getElementById('pot').textContent = `Pot actuel : ${state.pot}`;

    // Active ou désactive les boutons d'action en fonction du tour du joueur
    const actionButtons = document.getElementById('actionButtons');
    if (state.playerTurn === myPlayerId) {
        actionButtons.style.display = 'block';
    } else {
        actionButtons.style.display = 'none';
    }

}
function getRank(card) {
    return card.slice(0, -1);
}
function createCardElement(card) {
    const cardDiv = document.createElement('div');
    cardDiv.classList.add('card');

    const rankDiv = document.createElement('div');
    rankDiv.classList.add('rank');
    rankDiv.textContent = getRank(card);
    const suitDiv = document.createElement('div');
    suitDiv.classList.add('suit');
    suitDiv.innerHTML = getSuitHTML(card);

    if (['H', 'D'].includes(card.slice(-1))) {
        cardDiv.classList.add('red');
    }
    if (card === 'dos') {
        cardDiv.classList.add('BackgroundRed');
    }

    cardDiv.appendChild(rankDiv);
    cardDiv.appendChild(suitDiv);

    return cardDiv;
}
function getSuitHTML(card) {
    const suitCode = card.slice(-1);
    switch (suitCode) {
        case 'H':
            return '&hearts;';
        case 'S':
            return '&spades;';
        case 'C':
            return '&clubs;';
        case 'D':
            return '&diams;';
        default:
            return '';
    }
}
function displayPlayerCards(cards) {
    if (!Array.isArray(cards)) {
        console.error("Invalid cards data:", cards);
        return;
    }
    const cardsHtml = cards.map(card => createCardElement(card).outerHTML).join('');
    document.getElementById('player-hand').innerHTML = cardsHtml;
}
