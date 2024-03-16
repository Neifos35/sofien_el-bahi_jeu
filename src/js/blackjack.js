document.addEventListener('DOMContentLoaded', function() {
    const status = document.getElementById('status');
    const dealerHand = document.getElementById('dealer-hand');
    const playerHand = document.getElementById('player-hand');
    const cardsContainer = document.getElementById('cards');
    const hitBtn = document.getElementById('hit-btn');
    const standBtn = document.getElementById('stand-btn');
    const resetBtn = document.getElementById('reset-btn');

    let deck = [];
    let dealerCards = [];
    let playerCards = [];
    let gameOver = false;

    function createDeck() {
        const suits = ['H', 'S', 'C', 'D'];
        const values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

        for (let suit of suits) {
            for (let value of values) {
                deck.push(`${value}${suit}`);
            }
        }

        deck = shuffle(deck);
    }

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    function dealCards() {
        dealerCards.push("dos");
        playerCards.push(deck.pop());
        dealerCards.push(deck.pop());
        playerCards.push(deck.pop());
    }

    function displayCards() {
        cardsContainer.innerHTML = '';

        dealerCards.forEach(card => {
            const cardDiv = createCardElement(card);
            dealerHand.appendChild(cardDiv);
        });

        playerCards.forEach(card => {
            const cardDiv = createCardElement(card);
            playerHand.appendChild(cardDiv);
        });


        document.getElementById('player-score-value').textContent = calculateSum(playerCards);
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

    function getRank(card) {
        return card.slice(0, -1);
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

    function isBust(cards) {
        const sum = calculateSum(cards);
        return sum > 21;
    }



    function calculateSum(cards) {
        let sum = 0;
        let hasAce = false;

        for (let card of cards) {
            const value = getRank(card);
            if (value === 'A') {
                hasAce = true;
            }
            sum += getValue(value);
        }

        if (hasAce && sum + 10 <= 21) {
            sum += 10;
        }

        return sum;
    }

    function getValue(value) {
        if (value === 'A') {
            return 1;
        } else if (['10', 'J', 'Q', 'K'].includes(value)) {
            return 10;
        } else {
            return parseInt(value);
        }
    }


    function deleteCards() {
        dealerHand.innerHTML = '';
        playerHand.innerHTML = '';
    }

    function dropDisplayCard() {
        deleteCards();

        dealerCards.forEach(card => {
            const cardDiv = createCardElement(card);
            dealerHand.appendChild(cardDiv);
        });

        playerCards.forEach(card => {
            const cardDiv = createCardElement(card);
            playerHand.appendChild(cardDiv);
        });
    }

    function checkResult() {
        const dealerSum = calculateSum(dealerCards);
        const playerSum = calculateSum(playerCards);

        if (isBust(playerCards)) {
            status.textContent = 'Vous avez dépassé 21. Vous avez perdu.';
        } else if (playerSum === 21) {
            status.textContent = 'Blackjack! Vous avez gagné!';
        } else if (isBust(dealerCards)) {
            status.textContent = 'Le croupier a dépassé 21. Vous avez gagné!';
        } else if (dealerSum === 21) {
            status.textContent = 'Le croupier a un Blackjack. Vous avez perdu.';
        } else if (gameOver) {
            if (playerSum > dealerSum) {
                status.textContent = 'Vous avez gagné!';
            } else if (playerSum < dealerSum) {
                status.textContent = 'Le croupier a gagné.';
            }
        }
    }
    function playDealer() {
        // Supprimer la première carte face cachée du dealer
        dealerCards.shift(); // Supprime la première carte du tableau dealerCards

        while (calculateSum(dealerCards) < 17) {
            dealerCards.push(deck.pop());
        }
        document.getElementById('dealer-score-value').textContent = calculateSum(dealerCards);
        dropDisplayCard();
        checkResult();
        gameOver = true;
    }

    function getCard() {
        if (!gameOver) {
            if (hitBtn === this) {
                playerCards.push(deck.pop());
                dropDisplayCard();
                document.getElementById('player-score-value').textContent = calculateSum(playerCards);
                if (isBust(playerCards)) {
                    status.textContent = 'Vous avez dépassé 21. Vous avez perdu.';
                    gameOver = true;
                }
            } else if (standBtn === this) {
                playDealer();

            }

        }
    }
    function init() {
        deck = [];
        dealerCards = [];
        playerCards = [];
        gameOver = false;
        createDeck();
        dealCards();
        displayCards();
        status.textContent = 'C\'est à votre tour.';
    }
    init();


    hitBtn.addEventListener('click', getCard);
    standBtn.addEventListener('click', getCard);
    resetBtn.addEventListener('click', function() {
        init();
        dropDisplayCard(); // Réinitialise simplement l'affichage des cartes sans ajouter de nouvelles cartes
    });


});

