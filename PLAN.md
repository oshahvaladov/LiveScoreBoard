# Live Score Board - Development Plan

This document outlines the plan to create the Live Score Board application as discussed.

## 1. Core Requirements

- **Goal:** Create a backend library for a live football scoreboard.
- **Framework:** Must use Symfony.
- **Interface:** An interactive Symfony Console Command (`php bin/console app:scoreboard`).
- **Storage:** In-memory only. Data is lost when the application stops.
- **Functionality:**
    - `startGame(homeTeam, awayTeam)`
    - `finishGame(homeTeam, awayTeam)`
    - `updateScore(homeTeam, awayTeam, homeScore, awayScore)`
    - `getSummary()`
- **Sorting:** The summary must be sorted by total score (descending), then by most recently added game (descending).

## 2. Implementation Details

- **Project Type:** Symfony Console Application.
- **Core Logic:** A `FootballScoreBoard` service, registered as a singleton in the DI container, will hold the `Match` objects in a private array property.
- **Entry Point:** A `ScoreBoardCommand` class will provide the interactive prompt and parse user input.
- **Error Handling:** Custom exceptions (`MatchAlreadyExistsException`, `MatchNotFoundException`) will be used for logical errors. The command will handle invalid user input gracefully.

## 3. Edge Cases to Handle

- **Start Game:**
    - Game already exists.
    - Team vs. itself.
    - Empty/invalid team names.
    - Case-insensitivity for team names.
- **Update Score:**
    - Game does not exist.
    - Negative scores.
- **Finish Game:**
    - Game does not exist.
- **Summary:**
    - Empty scoreboard.
    - Multiple games with the same total score.
- **Command Input:**
    - Invalid commands.
    - Incorrect number of arguments.

## 4. Git Commit Strategy

1.  `Initial commit` (Symfony skeleton).
2.  `Chore: Configure project dependencies` (e.g., PHPUnit).
3.  `Feat: Add Match entity and ScoreBoard interface`.
4.  `Feat: Implement and test startGame functionality`.
5.  `Feat: Implement and test finishGame functionality`.
6.  `Feat: Implement and test updateScore functionality`.
7.  `Feat: Implement and test getSummary sorting logic`.
8.  `Feat: Add interactive console command`.
9.  `Docs: Add README with setup and usage instructions`.

## 5. Deadline

- The task should be ready by Monday, December 22, 2025.
