<?php

namespace Texas\TexasGame;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Texas\TexasGame\Deck;
use Texas\TexasGame\PokerHandEvaluator;


class TexasGame implements MessageComponentInterface {

    protected $connections = [];
    protected $deck;
    protected $gameState = [];
    protected $pot = 0;
    protected $currentBet = 0;
    protected $players = [];
    protected $smallBlind;
    protected $bigBlind;
    protected $dealerPosition = 0;

    protected $evaluator;

    public function __construct() {
        $this->deck = new Deck();
        $this->evaluator = new PokerHandEvaluator();
        $this->resetGameState();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->connections[$conn->resourceId] = $conn;
        $this->players[$conn->resourceId] = [
            'connection' => $conn,
            'hand' => [],
            'bet' => 0,
            'folded' => false,
        ];

        // Commence le jeu une fois que deux joueurs sont connectés
        if (count($this->connections) === 2) {
            $this->startGame();
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        error_log("Received message: " . $msg); // Log incoming messages
        $data = json_decode($msg, true);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            $this->sendMessage($from->resourceId, "Invalid JSON");
            return;
        }
        $playerId = $from->resourceId;

        switch ($data['action']) {
            case 'bet':
                $this->handleBet($playerId, $data['amount']);
                break;
            case 'fold':
                $this->handleFold($playerId);
                break;
            case 'check':
                $this->handleCheck($playerId);
                break;
            case 'raise':
                if (isset($data['amount']) && $data['amount'] > 0) {
                    $this->handleRaise($playerId, $data['amount']);
                } else {
                    $this->sendMessage($playerId, "Raise amount not provided or invalid.");
                }
                break;
        }

        $this->broadcastGameState();
    }

    public function onClose(ConnectionInterface $conn) {
        unset($this->connections[$conn->resourceId], $this->players[$conn->resourceId]);
        $this->resetGameState();
        // Gérez la déconnexion d'un joueur
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }


/**************** Début de la partie *******************/

    protected function startGame() {
        $this->deck->shuffle();
        foreach ($this->players as $playerId => $player) {
            $hand = $this->deck->deal(2);
            if (count($hand) !== 2) {
                error_log("Error dealing cards");
                continue; // ou gérer l'erreur différemment
            }
            $this->players[$playerId]['hand'] = $hand;
            $player['connection']->send(json_encode([
                'action' => 'deal',
                'hand' => $hand
            ]));
            error_log("Dealt cards to player {$playerId}: " . print_r($hand, true)); // Log dealt hands
        }

        $this->gameState['currentPhase'] = 'betting';

        // paramètres de la partie
        $this->smallBlind = 10; // example value
        $this->bigBlind = 20; // example value

        // Déterminez la position du dealer, de la petite et de la grosse blind
        $this->dealerPosition = array_key_first($this->players);
        $smallBlindPosition = ($this->dealerPosition + 1) % count($this->players);
        $bigBlindPosition = ($this->dealerPosition + 2) % count($this->players);

        // Post the blinds
        $this->players[$smallBlindPosition]['bet'] = $this->smallBlind;
        $this->players[$bigBlindPosition]['bet'] = $this->bigBlind;
        $this->pot += $this->smallBlind + $this->bigBlind;


        $this->gameState['currentPlayer'] = ($bigBlindPosition + 1) % count($this->players);


        $this->broadcastGameState();
    }

/***************** Actions de jeu **********************/
    protected function handleBet($playerId, $amount) {

        if (!isset($this->players[$playerId]) || $this->players[$playerId]['folded']) {
            $this->sendMessage($playerId, "Erreur : Tu ne peux pas parier car vous vous êtes couché.");
            return;
        }

        if ($amount < 0) {
            $this->sendMessage($playerId, "Erreur : le montant de la mise n'est pas correct.");
            return;
        }

        if ($amount > $this->players[$playerId]['chips']) {
            // Not enough chips
            $this->sendMessage($playerId, "Erreur : Solde inssuffisant.");
            return;
        }

        // Ensure it is the player's turn
        if ($this->gameState['currentPlayer'] !== $playerId) {
            // Not this player's turn
            $this->sendMessage($playerId, "Erreur : Ce n'est pas votre tour.");
            return;
        }

        // Betting logic
        $this->players[$playerId]['bet'] += $amount;
        $this->players[$playerId]['chips'] -= $amount;
        $this->currentBet = max($this->currentBet, $this->players[$playerId]['bet']);
        $this->pot += $amount;

        // Confirm bet and broadcast new game state
        $this->sendMessage($playerId, "Vous avez misé : $amount.");
        $this->broadcastGameState();

        // Move to next player
        $this->advanceToNextPlayer();


    }

    protected function handleCheck($playerId) {
        if ($this->currentBet > 0) {
            $this->sendMessage($playerId, "Cannot check, there is a bet already.");
        } else {
            // Proceed with the check logic.
            // Usually involves advancing to the next player without changing the bet.
            $this->advanceToNextPlayer();
        }
        // Broadcast the updated game state to all players.
        $this->broadcastGameState();
    }

    protected function handleRaise($playerId, $raiseAmount) {
        // Assume $raiseAmount has been validated to be a positive number and is greater than the current bet.
        // Assume $playerId is validated to be the current player's turn.

        // Deduct the raise amount from player's chips.
        $this->players[$playerId]['chips'] -= $raiseAmount;
        // Add the raise amount to the player's current bet.
        $this->players[$playerId]['bet'] += $raiseAmount;
        // Update the current bet to match the raised amount.
        $this->currentBet = $this->players[$playerId]['bet'];
        // Add the raised amount to the pot.
        $this->pot += $raiseAmount;

        // Confirm the raise and broadcast new game state.
        $this->sendMessage($playerId, "You raised by $raiseAmount.");
        // Move to the next player.
        $this->advanceToNextPlayer();

        // Broadcast the updated game state to all players.
        $this->broadcastGameState();
    }
    protected function sendMessage($playerId, $message) {
        if (isset($this->connections[$playerId])) {
            $this->connections[$playerId]->send(json_encode(['message' => $message]));
        }
    }
    protected function handleFold($playerId) {
        if (!isset($this->players[$playerId]) || $this->players[$playerId]['folded']) {
            $this->sendMessage($playerId, "Error: You have already folded or are not recognized.");
            return;
        }


        $this->players[$playerId]['folded'] = true;
        $this->sendMessage($playerId, "Vous avez suivi.");

        // Broadcast the updated game state and check for the end of the game
        $this->broadcastGameState();
        $this->checkForEndOfGame();
    }


    /***************** Logique du jeu *******************/

    protected function advanceGamePhase() {
        // This is an array of game phases in order
        $phases = ['pre-flop', 'flop', 'turn', 'river', 'showdown'];

        // Find the current phase of the game
        $currentPhaseIndex = array_search($this->gameState['currentPhase'], $phases);

        // Check if the current phase is not the last one
        if ($currentPhaseIndex < count($phases) - 1) {
            // Move to the next phase
            $this->gameState['currentPhase'] = $phases[$currentPhaseIndex + 1];
        } else {
            // If the current phase is the last one, the game round is over, and you'd typically handle payouts here
            $this->handlePayouts();
            return;
        }

        switch ($this->gameState['currentPhase']) {
            case 'flop':
                // Deal the flop (3 community cards)
                $this->gameState['communityCards'] = $this->deck->deal(3);
                break;
            case 'turn':
                // Deal the turn (1 community card)
                $this->gameState['communityCards'][] = $this->deck->deal(1);
                break;
            case 'river':
                // Deal the river (1 community card)
                $this->gameState['communityCards'][] = $this->deck->deal(1);
                break;
            case 'showdown':
                // At showdown, all remaining players compare hands
                $this->handleShowdown();
                break;
        }

        // Réinitialiser les mises des joueurs pour le nouveau tour
        foreach ($this->players as $playerId => $player) {
            $this->players[$playerId]['bet'] = 0;
        }
        $this->currentBet = 0;

        $this->broadcastGameState();

        $this->checkForNextPhase();
    }
    protected function checkForNextPhase() {
        $allPlayersActed = true;
        foreach ($this->players as $player) {
            if (!$player['folded'] && $player['bet'] < $this->currentBet) {
                $allPlayersActed = false;
                break;
            }
        }

        if ($allPlayersActed) {
            // Tout le monde a agi, avancez à la prochaine phase
            $this->advanceGamePhase();
        }
    }
    protected function handlePayouts() {
        // Assuming showdown has been handled and winner(s) determined
        if (!isset($this->gameState['winner'])) {
            $this->handleShowdown();
        }

        $winnerId = $this->gameState['winner'];
        $this->awardPotToWinner($winnerId);
        $this->broadcastMessage("Player $winnerId wins the pot of " . $this->pot . ".");
        $this->resetGameState();  // Prepare for a new game
    }

    protected function handleShowdown() {
        $bestHand = null;
        $winnerId = null;
        foreach ($this->players as $playerId => $player) {
            if (!$player['folded']) {
                $playerHand = array_merge($player['hand'], $this->gameState['communityCards']);
                $handRank = $this->evaluator->evaluateHand($playerHand);
                if ($bestHand === null || $handRank > $bestHand) {
                    $bestHand = $handRank;
                    $winnerId = $playerId;
                }
            }
        }
        $this->gameState['winner'] = $winnerId;
        $this->broadcastMessage("Player $winnerId has the best hand.");
    }


    /*************** Gestion du prochain joueur **********************/

    // Détermination du prochain joueur
    protected function advanceToNextPlayer() {
        //
        $currentPlayerId = $this->getCurrentPlayerId();

        // Obtention des places des joueurs
        $playerIds = array_keys($this->players);

        // Obtention de la position du joueur actuel
        $currentPosition = array_search($currentPlayerId, $playerIds);

        // Trouver le prochain joueur
        $nextPosition = ($currentPosition + 1) % count($this->players);

        while ($this->players[$playerIds[$nextPosition]]['folded']) {
            $nextPosition = ($nextPosition + 1) % count($this->players);

            // Si tour complet, le round est terminé
            if ($nextPosition == $currentPosition) {

                $this->gameState['currentPlayer'] = null;
                return;
            }
        }

        // Définir le prochain joueur
        $this->gameState['currentPlayer'] = $playerIds[$nextPosition];

        $this->broadcastGameState();
    }

    protected function getCurrentPlayerId() {

        return $this->gameState['currentPlayer'] ?? null;
    }

    /***************** Fin du jeu **********************/

    protected function checkForEndOfGame() {
        $activePlayers = array_filter($this->players, function($player) {
            return !$player['folded'];
        });

        if (count($activePlayers) === 1) {
            $winnerId = key($activePlayers);
            $this->awardPotToWinner($winnerId);


            $this->broadcastGameState();

            // Réinitialiser l'état du jeu
            $this->resetGameState();
        } else {
            // Passer au joueur suivant
            $this->advanceToNextPlayer();
        }
    }

    protected function awardPotToWinner($playerId) {
        // Ajoutez le pot au solde du joueur gagnant
        $this->players[$playerId]['chips'] += $this->pot;

        // Mettre à jour l'état du jeu pour indiquer le gagnant et le montant gagné
        $this->gameState['winner'] = $playerId;
        $this->gameState['amountWon'] = $this->pot;

        // Réinitialiser le pot
        $this->pot = 0;
    }


    protected function broadcastGameState() {
        $state = $this->getGameState();
        foreach ($this->connections as $conn) {
            $conn->send(json_encode($state));
        }
    }
    protected function broadcastMessage($message) {
        foreach ($this->connections as $conn) {
            $conn->send(json_encode(['message' => $message]));
        }
    }

    protected function resetGameState() {
        $this->gameState = ['currentPhase' => 'waiting', 'communityCards' => [], 'winner' => null];
        $this->pot = 0;
        $this->currentBet = 0;
        foreach ($this->players as $playerId => $player) {
            $this->players[$playerId]['bet'] = 0;
            $this->players[$playerId]['folded'] = false;
            $this->players[$playerId]['hand'] = [];
        }
    }


    protected function getGameState() {
        // Renvoie l'état actuel du jeu
        return $this->gameState;
    }
}
