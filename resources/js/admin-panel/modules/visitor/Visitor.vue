<template>
    <div class="row" >
        <vueTable :title="'Visitors'" :fields="fields" api-url="/api/visitor" show-paginate>
        </vueTable>
    </div>
</template>
<script>
    import {mapActions} from "vuex";
    export default {
        data() {
            return {
                fields: [
                    {
                        name: 'id',
                        title: this.$t('id'),
                        titleClass: 'width-3-percent text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'article',
                        title: this.$t('article'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'ip',
                        title: 'IP',
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'views',
                        title: this.$t('views'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                ]
            }
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
        }
    }
</script>
