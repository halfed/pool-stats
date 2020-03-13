import { getAllPlayers } from '@/api/allPlayers.api.js';

export const getAllPlayersInfo = ({ commit }) => {

  return getAllPlayers()
    .then(players => {
      console.log("in action");
      console.log(players.data);
      commit('populatePlayers', players.data);
    });
}
