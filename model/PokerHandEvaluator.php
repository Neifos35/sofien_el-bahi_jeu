<?php

namespace Texas\TexasGame;
class PokerHandEvaluator {
    const RANKS = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    const HAND_RANKS = [
        'high_card' => 1,
        'pair' => 2,
        'two_pair' => 3,
        'three_kind' => 4,
        'straight' => 5,
        'flush' => 6,
        'full_house' => 7,
        'four_kind' => 8,
        'straight_flush' => 9,
        'royal_flush' => 10
    ];

    public function evaluateHand($cards) {
        usort($cards, function($a, $b) {
            return array_search($a->rank, self::RANKS) - array_search($b->rank, self::RANKS);
        });

        $handType = $this->determineHandType($cards);
        return self::HAND_RANKS[$handType];
    }

    private function determineHandType($cards) {
        $isFlush = $this->isFlush($cards);
        $isStraight = $this->isStraight($cards);

        if ($isFlush && $isStraight) {
            return $this->isRoyal($cards) ? 'royal_flush' : 'straight_flush';
        }

        $counts = $this->getRankCounts($cards);
        $pairs = 0;
        $threes = 0;
        $fours = 0;
        foreach ($counts as $count) {
            if ($count == 4) $fours++;
            if ($count == 3) $threes++;
            if ($count == 2) $pairs++;
        }

        if ($fours) return 'four_kind';
        if ($threes && $pairs) return 'full_house';
        if ($isFlush) return 'flush';
        if ($isStraight) return 'straight';
        if ($threes) return 'three_kind';
        if ($pairs == 2) return 'two_pair';
        if ($pairs == 1) return 'pair';

        return 'high_card';
    }

    private function getRankCounts($cards) {
        $counts = [];
        foreach ($cards as $card) {
            if (!isset($counts[$card->rank])) {
                $counts[$card->rank] = 0;
            }
            $counts[$card->rank]++;
        }
        return $counts;
    }

    private function isFlush($cards) {
        $firstSuit = $cards[0]->suit;
        foreach ($cards as $card) {
            if ($card->suit !== $firstSuit) {
                return false;
            }
        }
        return true;
    }

    private function isStraight($cards) {
        $values = array_map(function ($card) {
            return array_search($card->rank, self::RANKS);
        }, $cards);
        for ($i = 1; $i < count($values); $i++) {
            if ($values[$i] !== $values[$i - 1] + 1) {
                return false;
            }
        }
        return true;
    }

    private function isRoyal($cards) {
        return $cards[0]->rank === '10' && $this->isFlush($cards);
    }
}
