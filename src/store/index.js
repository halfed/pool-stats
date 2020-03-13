import Vue from 'vue';
import Vuex from 'vuex';
//Import global actions
import * as actions from './actions';
//Import global mutations
import * as mutations from './mutations';
//Import global getters
import * as getters from './getters';
import addingPlayers from './modules/addingPlayers'
import addingScores from './modules/addingScores'

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    playersList: []
  },
  getters,
  actions,
  mutations,
  modules: {
    addingPlayers,
    addingScores
  }
});
