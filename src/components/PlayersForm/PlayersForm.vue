<template>
  <form name="players-form" id="playersForm" class="grid-x grid-padding-x" v-on:submit.prevent="preventSubmit">
    <div class="medium-12 cell">
      <div class="grid-x grid-padding-x">
        <div class="medium-5 cell form-group">
          <label :class="{ 'form-group--error': $v.player1.$error }">
            Player 1
            <span class="error form-error" v-if="!$v.player1.cannotBeSelect && $v.player1.$error">Field is required</span>
            <span class="error form-error" v-if="!$v.player1.sameAsPlayer2 && player1 != 'SELECT'">Field Cannot Be The Same As Player 2</span>
            <select v-model="$v.player1.$model">
              <option>SELECT</option>
              <option v-for="player in players" v-bind:value="player.value">{{ player.name }}</option>
            </select>
          </label>
          

          <label :class="{ 'form-group--error': $v.player2.$error }">
            Player 2
            <span class="error form-error" v-if="!$v.player2.cannotBeSelect && $v.player2.$error">Field is required</span>
            <span class="error form-error" v-if="!$v.player2.sameAsPlayer1 && player1 != 'SELECT'">Field Cannot Be The Same As Player 1</span>
            <select v-model="$v.player2.$model">
              <option>SELECT</option>
              <option v-for="player in players" v-bind:value="player.value">{{ player.name }}</option>
            </select>
          </label>
        </div>

        <div class="medium-5 cell">
          <label :class="{ 'form-group--error': $v.player1Score.$error }">
            Player 1 Score
            <span class="error form-error" v-if="!$v.player1Score.cannotBeSelect && $v.player1Score.$error">Field is required</span>
            <span class="error form-error" v-if="!$v.player1Score.sameAsPlayer2Score && player2Score !== 'SELECT'">Field Cannot Be The Same As Player 2 Score</span>
            <select v-model="$v.player1Score.$model">
              <option>SELECT</option>
              <option v-for="stat in stats" v-bind:value="stat.value">{{ stat.name }}</option>
            </select>
          </label>

          <label :class="{ 'form-group--error': $v.player2Score.$error }">
            Player 2 Score
            <span class="error form-error" v-if="!$v.player2Score.cannotBeSelect && $v.player2Score.$error">Field is required</span>
            <span class="error form-error" v-if="!$v.player2Score.sameAsPlayer1Score && player1Score !== 'SELECT'">Field Cannot Be The Same As Player 1 Score</span>
            <select v-model="$v.player2Score.$model">
              <option>SELECT</option>
              <option v-for="stat in stats" v-bind:value="stat.value">{{ stat.name }}</option>
            </select>
          </label>
        </div>
      </div>
    </div>
    <div class="medium-12 cell button-group">
      <button type="button" class="button alert" @click="resetForm">Clear</button>
      <button type="submit" class="button success" v-bind:class="[$v.$anyError ? 'disabled' : '' ]">Submit</button>
    </div>
  </form>
</template>

<script>
  const { validationMixin, default: Vuelidate } = require('vuelidate');
  const { required, minLength, sameAs, not } = require('vuelidate/lib/validators');
  const cannotBeSelect = (value) => value != "SELECT";
  const defaultPlayerValues = {
    player1: 'SELECT',
    player2: 'SELECT',
    player1Score: 'SELECT',
    player2Score: 'SELECT',
  }

  export default {
    mixins: [validationMixin],
    props: {
      preventSubmitHandler: {
        type: Function
      }
    },
    data() {
      return {
        player1: 'SELECT',
        player2: 'SELECT',
        player1Score: 'SELECT',
        player2Score: 'SELECT',
        players: [{ name: 'Charlie', value: 2 }, { name: 'Denny', value: 3 }, { name: 'Edward', value: 1 }],
        stats: [{ name: 'WINNER', value: 1 }, { name: 'LOSER', value: 0 }]
      }
    },
    validations: {
      player1: {
        cannotBeSelect,
        sameAsPlayer2: not(sameAs('player2'))
      },
      player2: {
        cannotBeSelect,
        sameAsPlayer1: not(sameAs('player1'))
      },
      player1Score: {
        cannotBeSelect,
        sameAsPlayer2Score: not(sameAs('player2Score'))
      },
      player2Score: {
        cannotBeSelect,
        sameAsPlayer1Score: not(sameAs('player1Score'))
      }
    },
    methods: {
      preventSubmit: function (e) {
        e.preventDefault();
        this.$v.$touch();
        if (this.$v.$invalid) {
          this.submitStatus = 'ERROR'
        } else {
          this.sendPlayerStats();
          return false;
        }
        
      },
      sendPlayerStats: function () {
        let player1 = this.player1,
          player2 = this.player2,
          player1Score = this.player1Score,
          player2Score = this.player2Score;

        if (player1 === 'SELECT') {
          player1 = '';
        }
        if (player2 === 'SELECT') {
          player2 = '';
        }
        if (player1Score === 'SELECT') {
          player1Score = '';
        }
        if (player2Score === 'SELECT') {
          player2Score = '';
        }
        let playerRecords = {
          player1,
          player2,
          player1Score,
          player2Score
        }
        this.$emit('sendScoreData', playerRecords);
      },
      resetForm: function () {
        this.player1 = 'SELECT';
        this.player2 = 'SELECT';
        this.player1Score = 'SELECT';
        this.player2Score = 'SELECT';
      }
    }
  }
</script>

<style lang="scss">
  .players-form
  {
    background-color: #786396;
    padding: 1% 4% 2% 4%;
    h1 {
      color: #FFFFFF;
      font-weight: 700;
    }
    form {
      background-color: rgba(255, 252, 252, 0.8);
      border-radius: 5px;
      padding: 3%;
    }
  }
</style>
