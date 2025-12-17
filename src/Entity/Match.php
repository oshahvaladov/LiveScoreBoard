<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

class Match
{
    private int $homeScore = 0;
    private int $awayScore = 0;
    private readonly DateTimeImmutable $startTime;

    public function __construct(
        private readonly string $homeTeam,
        private readonly string $awayTeam
    ) {
        $this->startTime = new DateTimeImmutable();
    }

    public function getHomeTeam(): string
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): string
    {
        return $this->awayTeam;
    }

    public function getHomeScore(): int
    {
        return $this->homeScore;
    }

    public function getAwayScore(): int
    {
        return $this->awayScore;
    }

    public function getStartTime(): DateTimeImmutable
    {
        return $this->startTime;
    }

    public function updateScore(int $homeScore, int $awayScore): void
    {
        $this->homeScore = $homeScore;
        $this->awayScore = $awayScore;
    }

    public function getTotalScore(): int
    {
        return $this->homeScore + $this->awayScore;
    }
}
