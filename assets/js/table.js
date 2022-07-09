import Vue from 'vue';
import TableCard from '../components/TableCard';
import VModal from 'vue-js-modal';
Vue.use(VModal, { dialog: true });

new Vue({
	el: '#app',
	render: h => h(TableCard)
});
