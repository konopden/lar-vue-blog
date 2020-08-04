<template>
    <vueForm :title="this.$t('editTag')">
        <template slot="buttons">
            <router-link :to="{ name: 'admin-panel.tag' }" class="btn btn-sm btn-secondary" exact>
                {{ $t('back') }}
            </router-link>
        </template>
        <template slot="content">
            <TagForm :tag="tag" v-if="tag.id"></TagForm>
        </template>
    </vueForm>
</template>
<script>
    import TagForm from './Form';
    import {mapActions} from "vuex";
    export default {
        components:{
            TagForm
        },
        data(){
            return {
                tag: {}
            }
        },
        created() {
            this.loadTag();
        },
        methods:{
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            loadTag(){
                this.showLoader();
                axios.get('/api/tag/' + this.$route.params.id + '/edit').then(response => {
                    this.tag = response.data.data;
                    this.hideLoader();
                }).catch(error => {
                    if (error.response.status !== 200) {
                        toastr.error(this.$t('anErrorHasOccurred'));
                        this.hideLoader();
                    }
                });
            }
        }
    }
</script>
