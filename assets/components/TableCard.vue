<template>
	<div>
		<h1>Информация о столе: {{ data.id}} </h1>
		<h2>Интересная информация: {{ data.description }} </h2>
		<h2>Отзывы: скоро будет </h2>
		<h2>Владелец: скоро будет </h2>
	</div>
</template>

<script>
import axios from 'axios'

export default {
	props: {
		},
	data() {
		return {
			id: 0,
			data: {}
		};
	},
	
	mounted() {
		let el = document.querySelector("div[data-id]");
		this.id = el.dataset.id;
		this.load(this.id);
	},
  methods: {
	  load(deskId)
	  {
		  axios.get('/api/desks/' + deskId)
				  .then(response =>
				  {
					  this.data = response.data;
					  console.log('this.roomParams: ', this.data);
				  })
				  .catch(error =>
				  {
					  console.log(error);
				  });
	  },
  }
};
</script>
