<template>
    <vueForm :title="$t('createArticle')">
        <template slot="buttons">
            <router-link :to="{ name: 'admin-panel.article' }" class="btn btn-sm btn-secondary" exact>
                {{ $t('back') }}
            </router-link>
        </template>
        <template slot="content">
            <ArticleForm></ArticleForm>
        </template>
    </vueForm>
</template>
<script>
    import ArticleForm from './Form'
    export default {
        components: { ArticleForm },
    }
</script>
