<?php

namespace App;

use App\Models\Leaderboard;

class RankPercentile
{
    protected $ranks = [1,5,10,25,50,75];

    protected $leaderboard;

    public function __construct(Leaderboard $leaderboard)
    {
        $this->leaderboard = $leaderboard;
    }

    public function calculate()
    {
        foreach ($this->ranks as $rank) {
            if ($this->leaderboard->rank_percentage <= $rank) {
                return $rank;
            }
        }

        return 100;
    }
}
