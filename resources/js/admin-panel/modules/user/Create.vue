<template>
    <vueForm :title="this.$t('createUser')">
        <template slot="buttons">
            <router-link :to="{ name: 'admin-panel.user' }" class="btn btn-sm btn-secondary" exact>
                {{ $t('back') }}
            </router-link>
        </template>
        <template slot="content">
            <user-form :user="{}">
            </user-form>
        </template>
    </vueForm>
</template>
<script>
    import UserForm from './Form'

    export default {
        components: { UserForm }
    }
</script>
