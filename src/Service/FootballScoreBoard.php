<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\ScoreBoardInterface;
use App\Entity\Game;

use App\Exception\MatchAlreadyExistsException;

use App\Exception\MatchNotFoundException;

class FootballScoreBoard implements ScoreBoardInterface
{
    /** @var Game[] */
    private array $matches = [];

    public function startGame(string $homeTeam, string $awayTeam): void
    {
        $matchKey = $this->getMatchKey($homeTeam, $awayTeam);
        if (isset($this->matches[$matchKey])) {
            throw new MatchAlreadyExistsException("Match between $homeTeam and $awayTeam already exists.");
        }

        $game = new Game($homeTeam, $awayTeam);
        $this->matches[$matchKey] = $game;
    }

    public function finishGame(string $homeTeam, string $awayTeam): void
    {
        $matchKey = $this->getMatchKey($homeTeam, $awayTeam);
        if (!isset($this->matches[$matchKey])) {
            throw new MatchNotFoundException("Match between $homeTeam and $awayTeam not found.");
        }
        unset($this->matches[$matchKey]);
    }

    public function updateScore(string $homeTeam, string $awayTeam, int $homeScore, int $awayScore): void
    {
        if ($homeScore < 0 || $awayScore < 0) {
            throw new \InvalidArgumentException('Scores cannot be negative.');
        }

        $matchKey = $this->getMatchKey($homeTeam, $awayTeam);
        if (!isset($this->matches[$matchKey])) {
            throw new MatchNotFoundException("Match between $homeTeam and $awayTeam not found.");
        }

        $this->matches[$matchKey]->updateScore($homeScore, $awayScore);
    }

    public function getSummary(): array
    {
        return array_values($this->matches);
    }

    private function getMatchKey(string $homeTeam, string $awayTeam): string
    {
        return strtolower($homeTeam) . '-' . strtolower($awayTeam);
    }
}