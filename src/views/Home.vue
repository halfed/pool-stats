  <template>
  <div class="home">
    <h1>Pool Stats</h1>
    <div class="grid-container full">
      <div class="display-body grid-x">
        <div class="cell column-display large-auto">
          <h3>
            MATCH
          </h3>
          <table>
            <thead><tr><th colspan="2" v-if="player2Info != '' || player3Info != '' ">{{ player2Info[0].first_name }} vs {{ player3Info[0].first_name }}</th></tr></thead>
            <tbody>
              <tr>
                <td>4</td>
                <td>4</td>
              </tr>
            </tbody>
          </table>
          <table>
            <thead><tr><th colspan="2" v-if="player1Info != '' || player2Info != '' ">{{ player1Info[0].first_name }} vs {{ player2Info[0].first_name }}</th></tr></thead>
            <tbody>
              <tr>
                <td>4</td>
                <td>4</td>
              </tr>
            </tbody>
          </table>
          <table>
            <thead><tr><th colspan="2" v-if="player1Info != '' || player3Info != '' ">{{ player1Info[0].first_name }} vs {{ player3Info[0].first_name }}</th></tr></thead>
            <tbody>
              <tr>
                <td>4</td>
                <td>4</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="cell large-auto column-display large-offset-1">
          <h3>
            GAMES PLAYED
          </h3>
          <table>
            <thead><tr><th colspan="2" v-if="player2Info != ''">{{ player2Info[0].first_name }}</th></tr></thead>
            <tbody>
              <tr>
                <td>4</td>
              </tr>
            </tbody>
          </table>
          <table>
            <thead><tr><th colspan="2" v-if="player3Info != ''">{{ player3Info[0].first_name }}</th></tr></thead>
            <tbody>
              <tr>
                <td>4</td>
              </tr>
            </tbody>
          </table>
          <table>
            <thead><tr><th colspan="2" v-if="player1Info != ''">{{ player1Info[0].first_name }}</th></tr></thead>
            <tbody>
              <tr>
                <td v-if="player1Info != ''">{{ player1Info[0].wins }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="cell large-auto column-display large-offset-1">
          <h3>
            WIN PERCENTAGE
          </h3>
          <table>
            <thead><tr><th colspan="2" v-if="player2Info != '' || player3Info != '' ">{{ player2Info[0].first_name }} vs {{ player3Info[0].first_name }}</th></tr></thead>
            <tbody>
              <tr>
                <td>40%</td>
                <td>40%</td>
              </tr>
            </tbody>
          </table>
          <table>
            <thead><tr><th colspan="2" v-if="player1Info != '' || player2Info != '' ">{{ player1Info[0].first_name }} vs {{ player2Info[0].first_name }}</th></tr></thead>
            <tbody>
              <tr>
                <td>40%</td>
                <td>40%</td>
              </tr>
            </tbody>
          </table>
          <table>
            <thead><tr><th colspan="2" v-if="player1Info != '' || player3Info != '' ">{{ player1Info[0].first_name }} vs {{ player3Info[0].first_name }}</th></tr></thead>
            <tbody>
              <tr>
                <td>40%</td>
                <td>40%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  // @ is an alias to /src
  import { getAllPlayers } from '@/api/allPlayers.api.js';
  import { mapActions } from 'vuex';

  export default {
    name: 'home',
    components: {
    },
    data() {
      return {
        counter: 0
      }
    },
    methods: {
      ...mapActions({
        fetchAllPlayersInfo: 'getAllPlayersInfo'
      }),
      increment() {
        this.count++
      },
    },
    computed: {
      player1Info() {
        return this.$store.getters.getPlayer1;
      },
      player2Info() {
        return this.$store.getters.getPlayer2;
      },
      player3Info() {
        return this.$store.getters.getPlayer3;
      }
    },
    created() {
      this.fetchAllPlayersInfo();
    }
  }
</script>
<style lang="scss">

  .home
  {
    width: 80%;
    margin: auto;
  }

  .column-display
  {
    h3 {
      background-color: #004d7f;
      color: #FFFFFF;
      font-weight: 700;
      margin: 0;
    }
  }

  .column-content
  {
    border: 1px solid black;
    padding-top: 5px;
  }

  table
  {
    margin-bottom: 0;
    th

  {
    text-align: center;
  }
  }
</style>
