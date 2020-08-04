<template>
    <vueForm :title="this.$t('back')">
        <template slot="buttons">
            <router-link :to="{ name: 'admin-panel.user' }" class="btn btn-sm btn-secondary" exact>
                {{ $t('back') }}
            </router-link>
        </template>
        <template slot="content">
            <UserForm :user="user" v-if="user.id">
            </UserForm>
        </template>
    </vueForm>
</template>
<script>
    import UserForm from './Form';
    import {mapActions} from "vuex";
    export default {
        components:{
            UserForm
        },
        data(){
            return {
                user: {}
            }
        },
        created() {
            this.loadUser();
        },
        methods:{
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            loadUser(){
                this.showLoader();
                axios.get('/api/user/' + this.$route.params.id + '/edit').then(response => {
                    this.user = response.data.data;
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
