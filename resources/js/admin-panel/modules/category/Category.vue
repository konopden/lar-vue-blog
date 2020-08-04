<template>
    <div class="row" >
        <vueTable :title="'Categories'" :fields="fields" api-url="/api/category" @table-action="tableAction" show-paginate>
            <template slot="buttons">
                <router-link :to="{ name: 'admin-panel.category.create' }" class="btn btn-sm btn-block btn-success">
                    {{ $t('createCategory') }}
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
                        name: 'name',
                        title: this.$t('title'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'path',
                        title: this.$t('path'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'description',
                        title: this.$t('description'),
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
                    this.$router.push({ name: 'admin-panel.category.edit', params: { id: data.id } })
                }
                else if(action == 'delete-item'){
                    this.showLoader();
                    axios.delete('/api/category/' + data.id).then(response => {
                        toastr.success(this.$t('categorySuccessfullyDeleted'));
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
