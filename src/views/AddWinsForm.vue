<template>
	<div class="players-form grid-container">
	  <h1>Players Form</h1>
    <players-form @sendScoreData="SubmitHandler($event)"/>
	</div> 
</template>

<script>
  import PlayersForm from '../components/PlayersForm/PlayersForm.vue';
  import { addScores } from '@/api/addScores.api.js';

  export default {
    components: {
      PlayersForm
    },
		data() {
			return {
				visible: true
			}
    },
    methods: {
      SubmitHandler: function(e) {
        console.log(e);
        const response = addScores(e)
            .then(function (response) {
              console.log(response);
        });
      }
    }
	}
</script>

<style lang="scss">
  .fade-enter-to
  {
    transition: opacity 0.9s;
  }

	.fade-enter-active {
		transition: opacity 0.5s;

		.change {
			color: red;
		}
	}

	.fade-leave-active {
	  transition: opacity 0.5s;
	}
	.fade-enter, .fade-leave-to {
	  opacity: 0;
	}
</style>
