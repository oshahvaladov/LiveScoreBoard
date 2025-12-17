<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Exception\MatchAlreadyExistsException;
use App\Exception\MatchNotFoundException;
use App\Service\FootballScoreBoard;
use PHPUnit\Framework\TestCase;

class FootballScoreBoardTest extends TestCase
{
    private FootballScoreBoard $scoreBoard;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scoreBoard = new FootballScoreBoard();
    }

    public function testStartGameSuccessfully(): void
    {
        // When
        $this->scoreBoard->startGame('Mexico', 'Canada');

        // Then
        $summary = $this->scoreBoard->getSummary();
        $this->assertCount(1, $summary, 'The summary should contain exactly one match.');

        $match = $summary[0];
        $this->assertSame('Mexico', $match->getHomeTeam());
        $this->assertSame('Canada', $match->getAwayTeam());
        $this->assertSame(0, $match->getHomeScore());
        $this->assertSame(0, $match->getAwayScore());
    }

    public function testStartGameAlreadyExistsThrowsException(): void
    {
        // Given
        $this->scoreBoard->startGame('Mexico', 'Canada');

        // Then
        $this->expectException(MatchAlreadyExistsException::class);
        $this->expectExceptionMessage('Match between Mexico and Canada already exists.');

        // When
        $this->scoreBoard->startGame('Mexico', 'Canada');
    }

    public function testFinishGameSuccessfully(): void
    {
        // Given
        $this->scoreBoard->startGame('Mexico', 'Canada');
        $this->scoreBoard->startGame('Spain', 'Brazil');

        // When
        $this->scoreBoard->finishGame('Mexico', 'Canada');

        // Then
        $summary = $this->scoreBoard->getSummary();
        $this->assertCount(1, $summary);

        $remainingGame = $summary[0];
        $this->assertSame('Spain', $remainingGame->getHomeTeam());
        $this->assertSame('Brazil', $remainingGame->getAwayTeam());
    }

    public function testFinishGameThatDoesNotExistThrowsException(): void
    {
        // Then
        $this->expectException(MatchNotFoundException::class);
        $this->expectExceptionMessage('Match between Mexico and Canada not found.');

        // When
        $this->scoreBoard->finishGame('Mexico', 'Canada');
    }
}
