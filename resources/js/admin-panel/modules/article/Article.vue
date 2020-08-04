<template>
    <div class="row" >
        <vueTable :title="'Articles'" :fields="fields" api-url="/api/article" @table-action="tableAction" show-paginate>
            <template slot="buttons">
                <router-link :to="{ name: 'admin-panel.article.create' }" class="btn btn-sm btn-block btn-success">
                    {{ $t('createArticle') }}
                </router-link>
            </template>
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
                        name: 'title',
                        title: this.$t('title'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'subtitle',
                        title: this.$t('subtitle'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'created_at',
                        title: this.$t('createdAt'),
                        titleClass: 'text-left',
                        dataClass: 'text-left width-10-percent'
                    },
                    {
                        name: 'published_at',
                        title: this.$t('publishedAt'),
                        titleClass: 'text-left',
                        dataClass: 'text-left width-10-percent'
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
                    this.$router.push({ name: 'admin-panel.article.edit', params: { id: data.id } })
                }
                else if(action == 'delete-item'){
                    this.showLoader();
                    axios.delete('/api/article/' + data.id).then(response => {
                        toastr.success(this.$t('articleSuccessfullyDeleted'));
                        this.$emit('reload');
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
    }
</script>
