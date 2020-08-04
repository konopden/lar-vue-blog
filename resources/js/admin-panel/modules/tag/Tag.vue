<template>
    <div class="row" >
        <vueTable :title="this.$t('tags')" :fields="fields" api-url="/api/tag" @table-action="tableAction" show-paginate>
            <template slot="buttons">
                <router-link :to="{ name: 'admin-panel.tag.create' }" class="btn btn-sm btn-block btn-success">
                    {{ $t('createTag') }}
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
                        name: 'tag',
                        title: this.$t('tag'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'title',
                        title: this.$t('title'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'meta_description',
                        title: this.$t('metaDesc'),
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
                    this.$router.push({ name: 'admin-panel.tag.edit', params: { id: data.id } })
                }
                else if(action == 'delete-item'){
                    this.showLoader();
                    axios.delete('/api/tag/' + data.id).then(response => {
                        toastr.success(this.$t('tagSuccessfullyDeleted'));
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
