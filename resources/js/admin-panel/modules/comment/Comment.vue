<template>
    <div class="row" >
        <vueTable :title="$t('comments') " :fields="fields" api-url="/api/comment" @table-action="tableAction" show-paginate>
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
                        name: 'username',
                        title: this.$t('userName'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'article_title',
                        title: this.$t('articleTitle'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'content',
                        title: this.$t('content'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'created_at',
                        title: this.$t('createdAt'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'component',
                        title: this.$t('enabled'),
                        titleClass: 'text-left',
                        dataClass: 'text-left',
                        component: true
                    },
                    {
                        name: 'actions',
                        title: this.$t('actions'),
                        titleClass: 'text-left width-10-percent',
                        dataClass: 'actions text-left',
                        action: true
                    },
                ]
            }
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            tableAction(action, data){
                if(action == 'edit-item'){
                    this.$router.push({ name: 'admin-panel.comment.edit', params: { id: data.id } })
                }
                else if(action == 'delete-item'){
                    this.showLoader();
                    axios.delete('/api/comment/' + data.id).then(response => {
                        toastr.success(this.$t('commentSuccessfullyDeleted'));
                        this.$emit('reload');
                        this.hideLoader();
                        this.$router.go(-1);
                    }).catch(error => {
                        if (error.response.status !== 200) {
                            toastr.error(this.$t('anErrorHasOccurred'));
                            this.hideLoader();
                        }
                    });
                }
            }
        }
    }
</script>
