<template>
    <div class="row">
        <form class="form col-md-4 offset-md-4" @submit.prevent="onSubmit">
            <div class="form-group text-center">
                <img :src="user.avatar ? user.avatar : '/images/img-not-found.png'" id="avatar" class="rounded-circle"
                     width="100" :alt="user.name">
            </div>
            <div class="form-group">
                <label for="name">{{ $t('name') }}</label>
                <input type="text" id="name" v-model="user.name" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">{{ $t('email') }}</label>
                <input type="text" id="email" v-model="user.email" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">{{ $t('information') }}</label>
                <textarea rows="3" name="info" id="info" class="form-control" v-model="user.info"></textarea>
            </div>
            <template v-if="!user.id">
                <div class="form-group">
                    <label for="password">{{ $t('password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" v-model="user.password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{ $t('confirmPassword') }}</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                           v-model="user.password_confirmation">
                </div>
            </template>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ user.id ? this.$t('edit') : this.$t('create') }}
                </button>
            </div>
        </form>
    </div>
</template>
<script>
    import {mapActions} from "vuex";
    export default {
        props: {
            user: {
                type: Object
            },
        },
        computed: {
            mode() {
                return this.user.id ? 'update' : 'create'
            },
        },
        methods: {
            ...mapActions([
                'showLoader', 'hideLoader'
            ]),
            onSubmit() {
                this.showLoader();
                let url = 'user' + (this.user.id ? '/' + this.user.id : '');
                let method = this.user.id ? 'patch' : 'post';
                axios[method]('/api/' + url, this.user).then(response => {
                    toastr.success( this.$t('you') + ' ' + this.$t(this.mode+'d') + this.$t('newAccountInformation'));
                    this.hideLoader();
                }).catch(error => {
                    if (error.response.status !== 200) {
                        this.error = error.response.data.messages || 'anErrorHasOccurred';
                        toastr.error(this.$t( this.error));
                        this.hideLoader();
                    }
                });
            }
        }
    }
</script>
