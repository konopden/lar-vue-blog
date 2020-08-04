<template>
    <div class="row" >
        <vueTable :title="this.$t('users')" :fields="fields" api-url="/api/user" @table-action="tableAction" show-paginate>
            <template slot="buttons">
                <router-link :to="{ name: 'admin-panel.user.create' }" class="btn btn-sm btn-block btn-success">
                    {{ $t('createUser') }}
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
                        name: 'avatar',
                        title: this.$t('avatar'),
                        titleClass: 'text-left',
                        dataClass: 'text-left',
                        callback: 'avatar'
                    },
                    {
                        name: 'name',
                        title: this.$t('name'),
                        titleClass: 'text-left',
                        dataClass: 'text-left'
                    },
                    {
                        name: 'email',
                        title: this.$t('email'),
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
                        titleClass: 'text-left',
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
            avatar(value) {
                if(!value)
                    value = '/images/img-not-found.png';
                return '<img alt="avatar" src="' + value + '" class="w-25 img-fluid rounded-circle" />';
            },
            tableAction(action, data){
                if(action == 'edit-item'){
                    this.$router.push({ name: 'admin-panel.user.edit', params: { id: data.id } })
                }
                else if(action == 'delete-item'){
                    this.showLoader();
                    axios.delete('/api/user/' + data.id).then(response => {
                        toastr.success(response.data);
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
