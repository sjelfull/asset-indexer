<template>
	<div class="assetindexer">
        <div class="assetindexer__inner">
            <h1 v-if="isIndexing">Is indexing!</h1>
            <asset-source :source="source" v-for="source in sources" @startIndexing="indexSource"></asset-source>
        </div>
    </div>
</template>
<script>
	import Vue from 'vue';
	import Serialize from '../utils/serialize';
	import AssetSource from './source.vue';
	//import {* as Craft } from 'craft';
	const Craft = require('craft');

	import VueResource from 'vue-resource';
	Vue.use(VueResource);
	Vue.http.options.emulateJSON = true;

	export default {
		components: { AssetSource },
		data: () => {
			return {
				isIndexing: false,
				sources: [],
				sse: null,
			}
		},
		methods: {
			startIndex: function() {
				this.isIndexing = true;
			},

			indexSource: function(params) {
			    console.log(arguments);
                const data = Serialize({ id: params.id });
                /*const headers = {
                    'Content-Type': "application/x-www-form-urlencoded",
                     'X-Requested-With': 'XMLHttpRequest'
                }*/

			    this.$http.post(Craft.getActionUrl('assetIndexer/getSources'), { id: params.id }).then((response) => {
                    console.log(response.body);

                    if (!this.isIndexing) {
                        this.sse = new EventSource(Craft.getActionUrl('assetIndexer/getIndexStatus'));
                        this.sse.addEventListener('update_index', function(e){
                            var data = e.data;
                            console.log(e);
                        }, false);

                        this.isIndexing = true;
                    }
                }, (response) => {
                    // Error
                });
			}
		},
		mounted: function() {
			const self = this;
			console.log(Craft);

            this.$http.get(Craft.getActionUrl('assetIndexer/getSources')).then((response) => {
                this.sources = response.body;
            }, (response) => {
                // Error
            });
		},
	}
</script>