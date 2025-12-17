<?php

declare(strict_types=1);

namespace App\Contract;

use App\Entity\Game;

interface ScoreBoardInterface
{
    public function startGame(string $homeTeam, string $awayTeam): void;

    public function finishGame(string $homeTeam, string $awayTeam): void;

    public function updateScore(string $homeTeam, string $awayTeam, int $homeScore, int $awayScore): void;

    /**
     * @return Game[]
     */
    public function getSummary(): array;
}
