<template>
    <vueForm :title="$t('editComment')">
        <template slot="buttons">
            <router-link :to="{ name: 'admin-panel.comment' }" class="btn btn-sm btn-secondary" exact>
                {{ $t('back') }}
            </router-link>
        </template>
        <template slot="content">
            <CommentForm :comment="comment"></CommentForm>
        </template>
    </vueForm>
</template>
<script>
    import CommentForm from './Form';
    import {mapActions} from "vuex";
    export default {
        components:{
            CommentForm
        },
        data(){
            return {
                comment: {}
            }
        },
        created() {
            this.loadComment();
        },
        methods:{
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            loadComment(){
                this.showLoader();
                axios.get('/api/comment/' + this.$route.params.id + '/edit').then(response => {
                    this.comment = response.data.data;
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
