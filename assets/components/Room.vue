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
    loadRoom(roomId, startDate)
    {
      axios.get('/api/booking/' + roomId + '/' + startDate)
      .then(response =>
      {
        this.roomParams = response.data;
      })
      .catch(error =>
      {
        console.log(error);
      });
    },
    bookDesk(deskId, startDate, endDate)
    {
      axios.post('/api/booking/book', {deskId: deskId, dateStart: startDate, dateEnd: endDate})
      .then(response =>
      {
        this.roomParams = response.data;
      })
      .catch(error =>
      {
        console.log(error);
      });
    },
    completeBooking(bookId, endDate)
    {
      axios.post('/api/booking/'+bookId+'/complete', {dateEnd: endDate})
      .then(response =>
      {
        this.roomParams = response.data;
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