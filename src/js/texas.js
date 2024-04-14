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
    try {

        const message = JSON.parse(event.data);
        switch (message.action) {
            case 'deal':
                displayPlayerCards(message.hand);
                break;
            case 'gameState':
                updateUI(message.state);
                break;
            case 'showdown':
                handleShowdown(message.result);
                break;
            default:
                console.log('Unhandled message:', message);
        }
    } catch (err) {
        console.error('Failed to process message:', event.data, err);
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
    document.getElementById('pot').textContent = `Pot actuel : ${state.pot}`;
    updateCommunityCards(state.communityCards);

    // Assuming 'myPlayerId' is correctly assigned the ID of the player in this session
    const isMyTurn = state.currentPlayer === myPlayerId;

    // Enable or disable buttons based on whether it's the player's turn
    toggleActionButton(isMyTurn);
}


/******************* Fonctions d'affichage des cartes *******************/
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

function toggleActionButton(enable) {
    const buttons = document.querySelectorAll('#actionButtons button');
    buttons.forEach(button => button.disabled = !enable);
}

// Affiche les cartes du joueur
function displayPlayerCards(cards) {
    if (!Array.isArray(cards)) {
        console.error("Invalid cards data:", cards);
        return;
    }
    const cardsHtml = cards.map(card => createCardElement(card).outerHTML).join('');
    document.getElementById('player-hand').innerHTML = cardsHtml;
}

function updateCommunityCards(cards) {
    const communityCardsContainer = document.getElementById('community-cards');
    communityCardsContainer.innerHTML = cards.map(card => createCardElement(card).outerHTML).join('');
}
function playerAction(action) {
    switch (action) {
        case 'check':
            sendAction('check');
            break;
        case 'fold':
            sendAction('fold');
            break;
        case 'raise':
            let raiseAmount = getRaiseAmount();
            if (raiseAmount) {
                sendAction('raise', raiseAmount);
            } else {
                console.error('Raise amount must be provided.');
            }
            break;
        default:
            console.error('Unknown action:', action);
    }
}

function getRaiseAmount() {
    const amount = parseFloat(document.getElementById('raiseAmountInput').value);
    return isNaN(amount) ? null : amount;
}
function updatePlayerActions(playerId, action, amount) {
    const actionsContainer = document.getElementById('actions');
    actionsContainer.textContent += `Player ${playerId} ${action} ${amount}\n`;
}

/************** Fin de la partie **************/
function handleShowdown(result) {
    // Display all hands and highlight the winner
    result.players.forEach(player => {
        const playerDiv = document.createElement('div');
        playerDiv.innerHTML = `<strong>Player ${player.id}</strong>: ` + player.hand.map(card => createCardElement(card).outerHTML).join('');
        if (player.id === result.winner) {
            playerDiv.classList.add('winner');
        }
        document.getElementById('results').appendChild(playerDiv);
    });
}
