<template>
    <vueForm :title="'Edit article'">
        <template slot="buttons">
            <router-link :to="{ name: 'admin-panel.article' }" class="btn btn-sm btn-secondary" exact>
                {{ $t('back') }}
            </router-link>
        </template>
        <template slot="content">
            <ArticleForm :article="article">
            </ArticleForm>
        </template>
    </vueForm>
</template>
<script>
    import ArticleForm from './Form';
    import {mapActions} from "vuex";
    export default {
        components:{
            ArticleForm
        },
        data(){
            return {
                article: {}
            }
        },
        created() {
            this.loadArticle();
        },
        methods:{
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            loadArticle(){
                this.showLoader();
                axios.get('/api/article/' + this.$route.params.id + '/edit?include=category,tags').then(response => {
                    this.article = response.data.data;
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
