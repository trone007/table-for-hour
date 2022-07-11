<template>
	<div>
    <Header></Header>
    <h2>Комната: {{ roomParams.name }}</h2>
    <div class="svg-container">
      <div class="svg-box">
        <div v-bind:style="{position: 'relative', width: roomParams.width + 'px', height: roomParams.length + 'px' }">
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
      bookingDate: "",
			words: [],
			roomParams: []
		};
	},
	mounted() {
    this.loadRoom(1, '2022-07-09');
	},
  methods: {
	  onTableClick(desk) {
		  this.$modal.show('dialog', {
			  title: 'Информация о столе',
			  text: '' +
            'Стол номер: ' + desk.id + (desk.bookingEnd ?  '<br>Забронирован до: <b>' + (new Date(desk.bookingEnd)).toDateString() + '</b>' : '') +
            ( desk.bookingUser ? '<br/>' +
            'Кто забронировал: ' + '<b>' + (desk.bookingUserName || desk.bookingUser) + '</b>' :
            '<br/>' +
            'Выберите дату бронирования: <input type="date" data-desk-id="'+desk.id+'" class="vue-booking-date">')
        ,
			  buttons: [
				  {
					  title: 'Забронировать',
					  handler: () => {
              const dateEnd = document.querySelector('input.vue-booking-date[data-desk-id="'+desk.id+'"]').value;
              axios.post('/api/booking/book', {
                deskId: desk.id,
                dateStart: dateEnd,
                dateEnd: dateEnd,
              })
              .then(response =>
              {
                desk.bookingStart = dateEnd;
                this.$modal.hide('dialog');
              })
              .catch(error =>
              {
                console.log(error);
              });
					  }
				  },
				  {
					  title: 'Снять бронь',
					  handler: () => {
              axios.post('/api/booking/desk/' +desk.id+ '/complete')
              .then(response =>
              {
                desk.bookingStart = null;
                this.$modal.hide('dialog');
              })
              .catch(error =>
              {
                console.log(error);
              });
					  }
				  },
				  {
					  title: 'О столе',
					  handler: () => {
						  this.$modal.hide('dialog');
						  window.location = '/table/' + desk.id;
					  }
				  },
          {
            title: 'Закрыть',
            handler: () => {
              this.$modal.hide('dialog')
            }
          },
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