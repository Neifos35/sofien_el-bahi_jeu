<?php

namespace Texas\TexasGame;

class Card {
    public $rank;
    public $suit;

    public function __construct($rank, $suit) {
        $this->rank = $rank;
        $this->suit = $suit;
    }
}
