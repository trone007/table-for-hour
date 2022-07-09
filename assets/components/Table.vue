<template>
		<div @click="onClick()"
				v-bind:style="{background: '#000', position: 'absolute', width: width + 'px', height: length + 'px', top: y + 'px', left: x + 'px' }">XXXXX</div>
</template>

<script>
import axios from 'axios'
export default {
	props: {
			id: Number,
			width: Number,
			length: Number,
			x: Number,
			y: Number,
			rotation: Number
		},
	data() {
		return {
			message: "A list of words",
			words: [],
			roomParams: []
		};
	},
	mounted() {
		console.log('sds');
	},
  methods: {
		onClick: function () {
			this.$emit('click', this.id);
		}
 
  }
};
</script>

<style>
.center {
	text-align: center;
}
</style>