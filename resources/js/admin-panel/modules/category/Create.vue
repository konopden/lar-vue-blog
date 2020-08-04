<template>
    <vueForm :title="$t('createCategory')">
        <template slot="buttons">
            <router-link :to="{ name: 'admin-panel.category' }" class="btn btn-sm btn-secondary" exact>
                {{ $t('back') }}
            </router-link>
        </template>
        <template slot="content">
            <CategoryForm></CategoryForm>
        </template>
    </vueForm>
</template>
<script>
    import CategoryForm from './Form'
    export default {
        components: { CategoryForm },
    }
</script>
