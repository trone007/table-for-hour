<template>
	<div>
    <Header></Header>
		<div v-bind:style="{background: '#ffffff', position: 'relative', width: roomParams.width + 'px', height: roomParams.length + 'px' }">
			<div v-for="(desk, m) in roomParams.desks" :key="m" class="row">
				<Table
            :id="desk.id"
						:x="desk.x"
						:y="desk.y"
						:rotation="desk.rotation"
						:length="desk.length"
						:width="desk.width"
            :occupied="!!desk.bookingStart"
						@click="onTableClick"
				/>
			</div>
		</div>
		<v-dialog />
	</div>
</template>

<script>
import axios from 'axios'
import Table from "./Table";
import Header from "./Header";

export default {
	components: {Table, Header},
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
	  onTableClick() {
		  this.$modal.show('dialog', {
			  title: 'The standard Lorem Ipsum passage',
			  text: 'Lorem ipsum dolor sit amet, ...',
			  buttons: [
				  {
					  title: 'Cancel',
					  handler: () => {
						  this.$modal.hide('dialog')
					  }
				  },
				  {
					  title: 'Like',
					  handler: () => {
						  alert('Like action')
					  }
				  },
				  {
					  title: 'Repost',
					  handler: () => {
						  alert('Repost action')
					  }
				  }
			  ]
		  })
	  },
    loadRoom(roomId, startDate)
    {
      axios.get('/api/booking/' + roomId + '/' + startDate)
      .then(response =>
      {
        this.roomParams = response.data;
	      console.log('this.roomParams: ', this.roomParams);
	
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