<?php

declare(strict_types=1);

namespace App\Command;

use App\Contract\ScoreBoardInterface;
use App\Entity\Game;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:scoreboard',
    description: 'Runs the interactive live scoreboard application.',
)]
class ScoreBoardCommand extends Command
{
    public function __construct(private readonly ScoreBoardInterface $scoreBoard)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Live Football World Cup Score Board');
        $io->text("Welcome! Type 'help' for a list of commands, 'exit' to quit.");

        while (true) {
            $commandline = $io->ask('scoreboard>');

            if ($commandline === null || $commandline === 'exit') {
                break;
            }
            if ($commandline === '') {
                continue;
            }

            $args = $this->parseCommand($commandline);
            $commandName = array_shift($args);

            try {
                match ($commandName) {
                    'start' => $this->startGame($args),
                    'update' => $this->updateScore($args),
                    'finish' => $this->finishGame($args),
                    'summary' => $this->printSummary($io),
                    'help' => $this->printHelp($io),
                    default => $io->error("Unknown command: '$commandName'. Type 'help' for commands."),
                };
            } catch (Exception $e) {
                $io->error($e->getMessage());
            }
        }

        $io->success('Goodbye!');
        return Command::SUCCESS;
    }

    private function parseCommand(string $commandline): array
    {
        preg_match_all('/"(?:\\.|[^\\"])*"|\S+/', $commandline, $matches);
        return array_map(static fn($arg) => trim($arg, '"'), $matches[0]);
    }

    private function startGame(array $args): void
    {
        if (count($args) !== 2) {
            throw new \InvalidArgumentException('Usage: start "Home Team" "Away Team"');
        }
        $this->scoreBoard->startGame($args[0], $args[1]);
    }

    private function updateScore(array $args): void
    {
        if (count($args) !== 4) {
            throw new \InvalidArgumentException('Usage: update "Home Team" "Away Team" <home_score> <away_score>');
        }
        $this->scoreBoard->updateScore($args[0], $args[1], (int)$args[2], (int)$args[3]);
    }

    private function finishGame(array $args): void
    {
        if (count($args) !== 2) {
            throw new \InvalidArgumentException('Usage: finish "Home Team" "Away Team"');
        }
        $this->scoreBoard->finishGame($args[0], $args[1]);
    }

    private function printSummary(SymfonyStyle $io): void
    {
        $summary = $this->scoreBoard->getSummary();
        if (empty($summary)) {
            $io->info('The scoreboard is currently empty.');
            return;
        }

        $io->table(
            ['Home Team', 'Home Score', 'Away Team', 'Away Score'],
            array_map(static fn(Game $game) => [
                $game->getHomeTeam(),
                $game->getHomeScore(),
                $game->getAwayTeam(),
                $game->getAwayScore(),
            ], $summary)
        );
    }

    private function printHelp(SymfonyStyle $io): void
    {
        $io->text('Available commands:');
        $io->listing([
            'start "Home Team" "Away Team"',
            'update "Home Team" "Away Team" <home_score> <away_score>',
            'finish "Home Team" "Away Team"',
            'summary',
            'help',
            'exit',
        ]);
    }
}
