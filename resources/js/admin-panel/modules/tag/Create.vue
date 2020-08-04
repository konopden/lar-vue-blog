<template>
    <vueForm :title="this.$t('createTag')">
        <template slot="buttons">
            <router-link :to="{ name: 'admin-panel.tag' }" class="btn btn-sm btn-secondary" exact>
                {{ $t('back') }}
            </router-link>
        </template>
        <template slot="content">
            <TagForm></TagForm>
        </template>
    </vueForm>
</template>
<script>
    import TagForm from './Form'
    export default {
        components: { TagForm },
    }
</script>
