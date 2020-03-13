<template>
  <div class="conn-four">
    <h1>Connect Four</h1>
    <div>
    	{{ name }}
    </div>
    <div v-for="team in highScoreAvg" >
    	{{ team.name }}
    </div>
  </div>
</template>

<script>
	export default {
		data() {
			return {
				name: "ed",
				bestNbaTeams: [
					{
						name: "Denver Nuggets",
						scoreAvg: 109

					},
					{
						name: "L.A Lakers",
						scoreAvg: 130
					},
					{
						name: "N.Y Knicks",
						scoreAvg: 125
					}
				]
			}
		},
		computed: {
			highScoreAvg() {
				return this.bestNbaTeams.filter(function(team) {
					return team.scoreAvg > 120;
				});
			}
		}
	}
</script>
