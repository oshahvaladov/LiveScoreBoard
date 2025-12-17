# Live Score Board

This is a simple command-line application for managing a live football world cup score board, built with Symfony.

## Requirements

- PHP 8.2 or higher
- Composer

## Setup

1.  Clone the repository.
2.  Navigate to the project directory.
3.  Install the dependencies:
    ```bash
    composer install
    ```

## Usage

To run the interactive scoreboard application, use the following command:

```bash
php bin/console app:scoreboard
```

This will start a session with a `scoreboard>` prompt.

### Available Commands

Once the application is running, you can use the following commands:

-   **`start "Home Team" "Away Team"`**
    *   Starts a new game with an initial score of 0-0.
    *   Example: `start "Mexico" "Canada"`

-   **`update "Home Team" "Away Team" <home_score> <away_score>`**
    *   Updates the score for an ongoing game.
    *   Example: `update "Mexico" "Canada" 1 0`

-   **`finish "Home Team" "Away Team"`**
    *   Removes a game from the scoreboard.
    *   Example: `finish "Mexico" "Canada"`

-   **`summary`**
    *   Displays a summary of all ongoing games, sorted by total score and then by start time.

-   **`help`**
    *   Displays the list of available commands.

-   **`exit`**
    *   Exits the application.
