<?php
$getAllPlayers = 'SELECT player_id, first_name, wins, loss FROM players';

$getPlayerInfo = 'SELECT wins, loss FROM players WHERE player_id = :playerId';

$getMaxPlayerId = 'SELECT max(player_id) FROM players';

$getMaxDailyId = 'SELECT max(daily_id) FROM daily_wins';

$insertPlayer = 'INSERT INTO players (first_name, wins, loss) VALUES (:fname, :win, :loss)';

$updatePlayer = 'UPDATE players SET wins = :win, loss = :loss  WHERE player_id = :id';

$insertDailyWins = 'INSERT INTO daily_wins (win, loss, opponent_id, date_played) VALUES (:win, :loss, :opponentId, :date)';

$insertPlayerToDaily = 'INSERT INTO player_to_daily_wins (player_id, daily_id) VALUES (:playerId, :dailyId)';

?>