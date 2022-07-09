<template>
	<div>
		<h2 class="center">My Application</h2>
		<div v-bind:style="{background: '#ffffff', position: 'relative', width: roomParams.width + 'px', height: roomParams.length + 'px' }">
			<div v-for="(desk, m) in roomParams.desks" :key="m" class="row">
				<Table
            :desk="desk"
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

export default {
	components: {Table},
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
	  onTableClick(desk) {
		  this.$modal.show('dialog', {
			  title: 'Информация о столе',
			  text: 'Стол номер: ' + desk.id + (desk.dateEnd ?  'Забронирован до:' +desk.dateEnd : ''),
			  buttons: [
				  {
					  title: 'Закрыть',
					  handler: () => {
						  this.$modal.hide('dialog')
					  }
				  },
				  {
					  title: 'Забронировать',
					  handler: () => {
						  alert('Like action')
					  }
				  },
				  {
					  title: 'Отзывы',
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