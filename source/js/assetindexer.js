import Vue from 'vue';
import App from './components/app.vue';

Vue.filter('json', function(object) {
    return JSON.stringify(object);
});


var vm = new Vue({
        el: '#assetIndexer',
        components: { App },
        render: (createElement) => {
            return createElement(App)
        }
});