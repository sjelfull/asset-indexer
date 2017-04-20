import Vue from 'vue';
//import Flow from '@flowjs/flow.js';
//import File from './components/file.vue';
import App from './components/app.vue';
import FilesizeFilter from './filters/filesize';

Vue.filter('filesize', FilesizeFilter);

Vue.filter('json', function(object) {
	return JSON.stringify(object);
});

const querySettings = {};

var vm = new Vue({	
	el: '#largeUpload',
	delimiters: ['[[', ']]'],
	components: { App },
	render: (createElement) => {
		return createElement(App);
	}
});