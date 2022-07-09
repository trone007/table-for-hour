<template>
	<div>
		<h2 class="center">My Application</h2>
		<div v-text="message"></div>
		{{ message }}
		<ul>
			<li :key="word.id" v-for="word in words">{{ word }}</li>
		</ul>
	</div>
</template>

<script>
import axios from 'axios'
export default {
	data() {
		return {
			message: "A list of words",
			words: [],
			roomParams: []
		};
	},
	mounted() {
		console.log('sds');
		Object.values(this.roomParams).forEach((value) => {
			console.log(value);
			});
    this.loadRoom(1, '2022-07-09');
	},
  methods: {
    loadRoom: function(roomId, startDate)
    {
      axios.get('/api/booking/' + roomId + '/' + startDate)
      .then(response =>
      {
        this.roomParams = response.data;
        console.log(this.roomParams)
      })
      .catch(error =>
      {
        console.log(error);
      });
    }
  }
};
</script>

<style>
.center {
	text-align: center;
}
</style>