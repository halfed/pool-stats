export const getPlayer1 = (state) => {
  return state.playersList.filter(player => player.player_id == 1);
}

export const getPlayer2 = (state) => {
  return state.playersList.filter(player => player.player_id == 2);
}

export const getPlayer3 = (state) => {
  return state.playersList.filter(player => player.player_id == 3);
}
