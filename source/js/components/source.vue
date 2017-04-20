<style>
    .source {
        background: rgba(235, 237, 239, 0.68);
        margin-bottom: 10px;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .source__button {

    }

    .source__label {
        margin-bottom: 0 !important;
    }
</style>
<template>
	<div class="source">
        <h3 class="source__label">{{ source.label }}</h3>
        <button class="source__button btn" @click.prevent="startIndexing">Start indexing</button>
    </div>
</template>
<script>
	export default {
	    props: ['source'],
		data: () => {
			return {
				isIndexing: false,
			}
		},
		methods: {
			startIndexing: function() {
				this.isIndexing = true;
				this.$emit('startIndexing', { source: this.source, id: this.source.criteria.folderId });
			}
		},
		mounted: function() {
			const self = this;
		},
	}
</script>