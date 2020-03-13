<template>
  <div>
    <form name="players-form" id="playersForm" class="grid-x grid-padding-x" v-on:submit.prevent="preventSubmit">
      <div class="medium-12 cell">
        <div class="medium-5 cell form-group">
          <label>
            Player 1
            <input name="player" id="player" type="text" />
          </label>
        </div>
      </div>
      <div class="medium-12 cell button-group">
        <button type="button" class="button alert">Clear</button>
        <button type="submit" class="button success">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
  import { getAllUsers } from '@/api/players.api.js';

  export default {
    data() {
      return {

      }
    },
    methods: {
      preventSubmit: function (e) {
        e.preventDefault();
        
        const response = getAllUsers()
          .then(function (data) {
            console.log(data);

          });
        return false;
      }
    }
  }
</script>

<style>

</style>
