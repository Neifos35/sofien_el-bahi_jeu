<?php

namespace Texas\TexasGame;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Texas\TexasGame\Deck;

class TexasGame implements MessageComponentInterface {
    protected $connections = [];
    protected $deck;
    protected $gameState = [];
    protected $pot = 0;
    protected $currentBet = 0;
    protected $players = [];

    public function __construct() {
        $this->deck = new Deck();
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
        $data = json_decode($msg, true);
        $playerId = $from->resourceId;

        switch ($data['action']) {
            case 'bet':
                $this->handleBet($playerId, $data['amount']);
                break;
            case 'fold':
                $this->handleFold($playerId);
                break;
            // Ajoutez d'autres actions comme 'raise', 'check', etc.
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

    protected function startGame() {
        $this->deck->shuffle();
        foreach ($this->players as $playerId => $player) {
            $this->players[$playerId]['hand'] = $this->deck->deal(2);
            // Envoyez les cartes de la main au joueur
            $player['connection']->send(json_encode([
                'action' => 'deal',
                'hand' => $this->players[$playerId]['hand'],
            ]));
        }

        $this->gameState['currentPhase'] = 'betting';


    }

    protected function handleBet($playerId, $amount) {
        // Gérez l'action de mise
    }

    protected function handleFold($playerId) {
        // Gérez l'action de se coucher
    }

    protected function broadcastGameState() {
        $state = $this->getGameState();
        foreach ($this->connections as $conn) {
            $conn->send(json_encode($state));
        }
    }

    protected function resetGameState() {
        $this->gameState = ['currentPhase' => 'waiting'];
        $this->pot = 0;
        $this->currentBet = 0;
        // Réinitialisez d'autres éléments de l'état du jeu
    }

    protected function getGameState() {
        // Renvoie l'état actuel du jeu
        return $this->gameState;
    }
}
