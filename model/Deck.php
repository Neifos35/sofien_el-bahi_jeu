<?php
namespace Texas\TexasGame;
class Deck {
private $cards = [];

public function __construct() {
    $suits = ['H', 'D', 'C', 'S'];
    $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    foreach ($suits as $suit) {
        foreach ($values as $value) {
            $this->cards[] = "$value $suit";
        }
    }
}

public function shuffle() {
    shuffle($this->cards);
}

public function deal($n) {
    return array_splice($this->cards, 0, $n);
    }
}
