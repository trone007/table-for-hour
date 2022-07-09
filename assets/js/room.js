import Vue from 'vue';
import Room from '../components/Room';
import VModal from 'vue-js-modal';
Vue.use(VModal, { dialog: true });

new Vue({
	el: '#app',
	render: h => h(Room)
});
